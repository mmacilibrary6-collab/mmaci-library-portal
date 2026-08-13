<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class LisaAssistant
{
    public function reply(string $message, array $history = []): array
    {
        $original = trim($message);
        $normalized = $this->normalizeText($original);

        if ($normalized === '') {
            return $this->fallbackResponse();
        }

        if ($this->isGreeting($normalized)) {
            return [
                'answer' => 'Hello! I’m Lisa, the MMACI Library Guide. I can help you find collections, academic-program resources, services, facilities, forms, events, contact details, and website pages.',
                'title' => 'How can I help?',
                'pageUrl' => null,
                'suggestions' => $this->defaultSuggestions(),
            ];
        }

        $directResponse = $this->directIntentResponse($normalized);

        if ($directResponse !== null) {
            $directResponse['suggestions'] = $this->sanitizeSuggestions(
                $directResponse['suggestions'] ?? [],
                $original
            );

            return $directResponse;
        }

        $searchText = $this->buildContextMessage($normalized, $history);
        $entries = $this->knowledgeEntries();

        $ranked = collect($entries)
            ->map(function (array $entry) use ($searchText) {
                $entry['_score'] = $this->score($searchText, $entry);
                return $entry;
            })
            ->filter(fn (array $entry) => $entry['_score'] > 0)
            ->sortByDesc('_score')
            ->values();

        $best = $ranked->first();

        if (! $best || $best['_score'] < 5) {
            return $this->fallbackResponse($original);
        }

        $answer = $this->varyAnswer(
            $this->publicFacingAnswer((string) $best['answer']),
            count($history)
        );

        return [
            'answer' => $answer,
            'title' => $best['title'] ?? 'MMACI Library',
            'suggestions' => $this->sanitizeSuggestions(
                collect($best['suggestions'] ?? [])
                    ->merge($this->relatedSuggestions($ranked->slice(1, 3)->all()))
                    ->all(),
                $original
            ),
            'pageUrl' => $best['pageUrl'] ?? null,
        ];
    }

    protected function buildContextMessage(string $message, array $history): string
    {
        if (empty($history) || ! $this->isFollowUpMessage($message)) {
            return $message;
        }

        $previousUserMessage = collect($history)
            ->reverse()
            ->first(function ($entry) use ($message) {
                return ($entry['role'] ?? null) === 'user'
                    && $this->normalizeText((string) ($entry['text'] ?? '')) !== $message;
            });

        if (! $previousUserMessage) {
            return $message;
        }

        return trim(
            $this->normalizeText((string) $previousUserMessage['text']).' '.$message
        );
    }

    protected function isFollowUpMessage(string $message): bool
    {
        $message = $this->normalizeText($message);
        $words = $this->words($message);

        if (count($words) > 5) {
            return false;
        }

        $followUpPhrases = [
            'what about', 'how about', 'and the', 'and what', 'also',
            'that one', 'this one', 'it', 'them', 'there', 'those',
            'yes', 'no', 'why', 'when',
        ];

        return Str::startsWith($message, $followUpPhrases)
            || in_array($message, $followUpPhrases, true);
    }

    protected function score(string $message, array $entry): int
    {
        $message = $this->normalizeText($message);
        $messageWords = $this->words($message);
        $score = 0;

        $title = $this->normalizeText((string) ($entry['title'] ?? ''));
        $answer = $this->normalizeText((string) ($entry['answer'] ?? ''));
        $keywords = array_merge([$title], $entry['keywords'] ?? []);

        foreach ($keywords as $keyword) {
            $keyword = $this->normalizeText((string) $keyword);

            if ($keyword === '') {
                continue;
            }

            if ($message === $keyword) {
                $score += 35;
            } elseif (Str::contains($message, $keyword)) {
                $score += str_contains($keyword, ' ') ? 20 : 11;
            }

            foreach ($this->words($keyword) as $keywordWord) {
                foreach ($messageWords as $messageWord) {
                    if ($keywordWord === $messageWord) {
                        $score += 5;
                    } elseif (
                        mb_strlen($keywordWord) >= 5
                        && mb_strlen($messageWord) >= 5
                        && levenshtein($keywordWord, $messageWord) <= 2
                    ) {
                        $score += 2;
                    }
                }
            }
        }

        foreach ($messageWords as $word) {
            if (mb_strlen($word) >= 4 && Str::contains($answer, $word)) {
                $score += 1;
            }
        }

        return $score;
    }

    protected function knowledgeEntries(): array
    {
        return Cache::remember('lisa.knowledge.entries.v7', now()->addMinutes(10), function () {
            return array_merge(
                $this->manualEntries(),
                $this->databaseEntries(),
                $this->scannedEntries()
            );
        });
    }

    protected function manualEntries(): array
    {
        return [
            [
                'title' => 'Home page',
                'keywords' => ['home', 'homepage', 'landing page', 'news', 'events', 'new arrivals', 'updates'],
                'answer' => 'The Home page presents MMACI Library announcements, events, new arrivals, featured resources, gallery highlights, and links to the main website sections.',
                'pageUrl' => url('/'),
                'suggestions' => ['What events are available?', 'Where are the new arrivals?', 'Show me the collections'],
            ],
            [
                'title' => 'About the library',
                'keywords' => ['about', 'mission', 'vision', 'goals', 'history', 'library hours', 'opening hours', 'schedule'],
                'answer' => 'The About section contains information about the MMACI Library Services Office, including its purpose, institutional information, and library details shown on the website.',
                'pageUrl' => url('/about'),
                'suggestions' => ['What are the library hours?', 'Where can I see the mission and vision?'],
            ],
            [
                'title' => 'E-books',
                'keywords' => ['ebook', 'ebooks', 'e-book', 'e-books', 'electronic book', 'digital book', 'find book', 'academic program resources'],
                'answer' => 'Open the E-books page, choose your academic program, and then select an available folder. The folder link opens the corresponding online resources, usually in Google Drive.',
                'pageUrl' => url('/collection/ebooks'),
                'suggestions' => ['What programs have E-books?', 'How do I open an E-book folder?', 'Where can I find Tourism E-books?'],
            ],
            [
                'title' => 'Thesis and dissertation',
                'keywords' => ['thesis', 'theses', 'dissertation', 'research paper', 'manuscript', 'capstone'],
                'answer' => 'Open the Thesis and Dissertation section, choose the relevant academic program, and select one of its available research folders.',
                'pageUrl' => url('/collection/theses'),
                'suggestions' => ['How do I find a thesis by program?', 'Where are research manuscripts?'],
            ],
            [
                'title' => 'Periodicals',
                'keywords' => ['periodical', 'journal', 'magazine', 'newspaper', 'clipping', 'article'],
                'answer' => 'The Periodicals section organizes journals, newspaper clippings, magazines, and similar materials by program or category. Use the available filters or program cards to browse them.',
                'pageUrl' => url('/collection/periodicals'),
                'suggestions' => ['Can I filter periodicals?', 'Where are journals and magazines?'],
            ],
            [
                'title' => 'Printed collection',
                'keywords' => ['printed books', 'printed collection', 'physical book', 'hardcopy', 'book shelf'],
                'answer' => 'The Printed Collection page introduces the physical library holdings and directs visitors to the available printed-book resources and collection information.',
                'pageUrl' => url('/collection/printed'),
                'suggestions' => ['Where can I find physical books?', 'What collections are available?'],
            ],
            [
                'title' => 'Donated books',
                'keywords' => ['donated book', 'donation', 'gifted book'],
                'answer' => 'The Donated Books page displays donated titles with their descriptions and cover images. Open the page to browse the currently published donated books.',
                'pageUrl' => url('/collection/donated-books'),
                'suggestions' => ['Show me donated books', 'How are donated books added?'],
            ],
            [
                'title' => 'Open access resources',
                'keywords' => ['open access', 'opac', 'catalog', 'free resource', 'public resource'],
                'answer' => 'The Open Access Resources section provides publicly available research tools, catalogs, and external learning resources. Select a resource card to open its website.',
                'pageUrl' => url('/collection/open-access'),
                'suggestions' => ['Where is the OPAC?', 'Show me free research resources'],
            ],
            [
                'title' => 'Subscribed online database',
                'keywords' => ['ebsco', 'subscribed database', 'online database', 'database login', 'database credentials'],
                'answer' => 'The Subscribed Online Database page provides access information for EBSCO and other subscribed resources. Contact the Circulation Staff if credentials are required.',
                'pageUrl' => url('/collection/subscribed-database'),
                'suggestions' => ['Where do I get EBSCO credentials?', 'Open the online database page'],
            ],
            [
                'title' => 'Services and facilities',
                'keywords' => ['service', 'services', 'facility', 'facilities', 'reading area', 'discussion room', 'computer', 'laptop', 'internet', 'borrowing'],
                'answer' => 'The Services and Facilities sections describe the library support, learning spaces, equipment, and other resources available to users.',
                'pageUrl' => url('/services'),
                'suggestions' => ['What facilities are available?', 'What services does the library offer?'],
            ],
            [
                'title' => 'Reserve AVR',
                'keywords' => ['reserve avr', 'avr', 'audio visual room', 'room reservation', 'book room'],
                'answer' => 'Use the Reserve AVR page to submit a request for the Audio Visual Room. Complete the form with the required schedule and activity information.',
                'pageUrl' => url('/more/reserve-avr'),
                'suggestions' => ['Open the AVR reservation form', 'What information is required?'],
            ],
            [
                'title' => 'Online book recommendation',
                'keywords' => ['recommend book', 'book recommendation', 'suggest a book', 'request a book'],
                'answer' => 'Use the Online Book Recommendation page to suggest a title that you would like the library to consider.',
                'pageUrl' => url('/more/online-book-recommendation'),
                'suggestions' => ['Open the book recommendation form', 'How do I suggest a title?'],
            ],
            [
                'title' => 'Gallery',
                'keywords' => ['gallery', 'photo', 'photos', 'album', 'pictures'],
                'answer' => 'The Gallery contains public photo albums and event images from the library. Select an album or image collection to view its contents.',
                'pageUrl' => url('/more/gallery'),
                'suggestions' => ['Open the gallery', 'What photos are available?'],
            ],
            [
                'title' => 'Ask the Librarian',
                'keywords' => ['ask librarian', 'contact librarian', 'contact library', 'contact mmaci', 'email', 'email address', 'gmail', 'facebook', 'phone', 'telephone', 'help desk', 'support'],
                'answer' => 'You can email the MMACI Library Services Office at mmacilibrary@mmacibutuan.edu.ph. The website footer also publishes mmacilibrary@gmail.com. You may call +63 948 553 2601 or message MMACI Library on Facebook.',
                'pageUrl' => url('/more/ask-librarian'),
                'suggestions' => ['What is the library email?', 'What is the contact number?', 'Where is the library located?', 'Open Ask the Librarian'],
            ],
            [
                'title' => 'Visiting users',
                'keywords' => ['visitor', 'visiting user', 'guest', 'outside user', 'non student'],
                'answer' => 'The Visiting Users page explains the information and procedures available for guests or users who are not regular MMACI library users.',
                'pageUrl' => url('/more/visiting-users'),
                'suggestions' => ['What should visitors know?', 'Open the visiting users page'],
            ],
        ];
    }

    protected function databaseEntries(): array
    {
        $definitions = [
            'ebook_programs' => ['label' => 'E-books', 'url' => '/collection/ebooks'],
            'ebook_folders' => ['label' => 'E-book folder', 'url' => '/collection/ebooks'],
            'thesis_programs' => ['label' => 'Thesis and Dissertation', 'url' => '/collection/theses'],
            'thesis_folders' => ['label' => 'Thesis folder', 'url' => '/collection/theses'],
            'periodical_programs' => ['label' => 'Periodicals', 'url' => '/collection/periodicals'],
            'periodical_folders' => ['label' => 'Periodical folder', 'url' => '/collection/periodicals'],
            'donated_books' => ['label' => 'Donated Books', 'url' => '/collection/donated-books'],
            'open_access_resources' => ['label' => 'Open Access Resources', 'url' => '/collection/open-access'],
            'calendar_events' => ['label' => 'Calendar Events', 'url' => '/'],
            'new_arrivals' => ['label' => 'New Arrivals', 'url' => '/'],
            'library_updates' => ['label' => 'Library Updates', 'url' => '/'],
            'facilities' => ['label' => 'Facilities', 'url' => '/services/facilities'],
            'services' => ['label' => 'Services', 'url' => '/services'],
            'gallery_folders' => ['label' => 'Gallery', 'url' => '/more/gallery'],
        ];

        $entries = [];

        foreach ($definitions as $table => $definition) {
            try {
                if (! Schema::hasTable($table)) {
                    continue;
                }

                $columns = collect(['title', 'name', 'program_name', 'folder_name', 'description', 'location', 'category'])
                    ->filter(fn ($column) => Schema::hasColumn($table, $column))
                    ->values();

                if ($columns->isEmpty()) {
                    continue;
                }

                $query = DB::table($table)->select($columns->all())->limit(250);

                if (Schema::hasColumn($table, 'status')) {
                    $query->where(function ($q) {
                        $q->where('status', 1)
                            ->orWhere('status', 'published')
                            ->orWhere('status', 'active');
                    });
                }

                foreach ($query->get() as $record) {
                    $data = (array) $record;
                    $title = collect(['title', 'name', 'program_name', 'folder_name'])
                        ->map(fn ($column) => trim((string) ($data[$column] ?? '')))
                        ->first(fn ($value) => $value !== '');

                    if (! $title) {
                        continue;
                    }

                    $description = trim((string) ($data['description'] ?? ''));
                    $category = trim((string) ($data['category'] ?? ''));
                    $location = trim((string) ($data['location'] ?? ''));

                    $details = collect([$description, $category ? "Category: {$category}." : '', $location ? "Location: {$location}." : ''])
                        ->filter()
                        ->implode(' ');

                    $entries[] = [
                        'title' => $title,
                        'keywords' => array_filter([
                            $title,
                            $definition['label'],
                            $category,
                            Str::singular($definition['label']),
                        ]),
                        'answer' => "I found {$title} under {$definition['label']}. ".($details ?: 'Open the related page to view the available information and resources.'),
                        'pageUrl' => url($definition['url']),
                        'suggestions' => [
                            "Open {$definition['label']}",
                            "Tell me more about {$title}",
                        ],
                    ];
                }
            } catch (Throwable) {
                continue;
            }
        }

        return $entries;
    }

    protected function scannedEntries(): array
    {
        $viewsPath = resource_path('views');

        if (! File::isDirectory($viewsPath)) {
            return [];
        }

        $excludedDirectories = ['admin/', 'auth/', 'components/', 'emails/', 'layouts/', 'partials/', 'vendor/'];

        return collect(File::allFiles($viewsPath))
            ->filter(function ($file) use ($viewsPath, $excludedDirectories) {
                $relative = Str::of($file->getPathname())
                    ->after(rtrim($viewsPath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR)
                    ->replace('\\', '/')
                    ->toString();

                return Str::endsWith($relative, '.blade.php')
                    && ! collect($excludedDirectories)->contains(
                        fn ($directory) => Str::startsWith($relative, $directory)
                    );
            })
            ->take(300)
            ->map(function ($file) {
                try {
                    $path = $file->getPathname();
                    $contents = File::get($path);
                    $relative = Str::of($path)
                        ->after(resource_path('views').DIRECTORY_SEPARATOR)
                        ->replace('\\', '/')
                        ->replace('.blade.php', '')
                        ->toString();

                    $title = $this->extractTitle($contents)
                        ?: Str::headline(basename($path, '.blade.php'));

                    $snippets = $this->extractSnippets($contents);
                    $pageUrl = $this->guessPageUrl($relative);

                    if ($pageUrl === null) {
                        return null;
                    }

                    return [
                        'title' => $title,
                        'keywords' => array_values(array_unique(array_filter(array_merge(
                            [$title, Str::headline(str_replace('/', ' ', $relative))],
                            $snippets['keywords']
                        )))),
                        'answer' => $snippets['answer'] ?: "The {$title} page is available on the MMACI Library website.",
                        'pageUrl' => $pageUrl,
                        'suggestions' => $snippets['suggestions'],
                    ];
                } catch (Throwable) {
                    return null;
                }
            })
            ->filter()
            ->values()
            ->all();
    }

    protected function extractTitle(string $contents): ?string
    {
        if (preg_match('/@section\\([\'\"](?:title|page-title)[\'\"]\\s*,\\s*[\'\"]([^\'\"]+)[\'\"]\\)/', $contents, $matches)) {
            return trim($matches[1]);
        }

        if (preg_match('/<h[12][^>]*>(.*?)<\\/h[12]>/si', $contents, $matches)) {
            $text = $this->cleanBladeText($matches[1]);
            return $text !== '' ? $text : null;
        }

        return null;
    }

    protected function extractSnippets(string $contents): array
    {
        $keywords = [];
        $paragraphs = [];

        if (preg_match_all('/<h[1-4][^>]*>(.*?)<\\/h[1-4]>/si', $contents, $matches)) {
            foreach ($matches[1] as $heading) {
                $text = $this->cleanBladeText($heading);
                if ($text !== '') {
                    $keywords[] = $text;
                }
            }
        }

        if (preg_match_all('/<p[^>]*>(.*?)<\\/p>/si', $contents, $matches)) {
            foreach ($matches[1] as $paragraph) {
                $text = $this->cleanBladeText($paragraph);
                if (mb_strlen($text) >= 20) {
                    $paragraphs[] = Str::limit($text, 220);
                }
            }
        }

        return [
            'keywords' => array_slice(array_unique($keywords), 0, 12),
            'suggestions' => collect($keywords)
                ->take(3)
                ->map(fn ($item) => $this->suggestionForTitle((string) $item))
                ->all(),
            'answer' => $paragraphs[0] ?? null,
        ];
    }

    protected function cleanBladeText(string $text): string
    {
        $text = preg_replace('/\\{\\{.*?\\}\\}|\\{!!.*?!!\\}|@\\w+(?:\\([^)]*\\))?/s', ' ', $text) ?? $text;
        $text = html_entity_decode(strip_tags($text));
        return preg_replace('/\\s+/', ' ', trim($text)) ?? trim($text);
    }

    protected function guessPageUrl(string $relative): ?string
    {
        $map = [
            'home' => '/',
            'welcome' => '/',
            'about' => '/about',
            'collection/printed' => '/collection/printed',
            'collection/ebooks' => '/collection/ebooks',
            'collection/open-access' => '/collection/open-access',
            'collection/theses' => '/collection/theses',
            'collection/donated-books' => '/collection/donated-books',
            'collection/periodicals' => '/collection/periodicals',
            'collection/subscribed-database' => '/collection/subscribed-database',
            'more/gallery' => '/more/gallery',
            'more/online-book-recommendation' => '/more/online-book-recommendation',
            'more/reserve-avr' => '/more/reserve-avr',
            'more/visiting-users' => '/more/visiting-users',
            'more/ask-librarian' => '/more/ask-librarian',
            'services/index' => '/services',
            'services/facilities' => '/services/facilities',
        ];

        return isset($map[$relative]) ? url($map[$relative]) : null;
    }

    protected function relatedSuggestions(array $entries): array
    {
        return collect($entries)
            ->map(fn ($entry) => isset($entry['title'])
                ? $this->suggestionForTitle((string) $entry['title'])
                : null)
            ->filter()
            ->all();
    }

    protected function suggestionForTitle(string $title): string
    {
        $title = trim(Str::before($title, '|'));
        $title = preg_replace('/\s+/', ' ', $title) ?? $title;

        return 'View '.Str::limit($title, 42, '...');
    }

    protected function isUsefulSuggestion(string $suggestion, string $question = ''): bool
    {
        if (
            $suggestion === ''
            || mb_strlen($suggestion) > 55
            || Str::contains(Str::lower($suggestion), ['http://', 'https://', 'drive.google.com'])
        ) {
            return false;
        }

        $suggestionWords = $this->words($suggestion);
        $questionWords = $this->words($question);
        $sharedWords = count(array_intersect($suggestionWords, $questionWords));
        $shortestLength = min(count($suggestionWords), count($questionWords));

        if ($shortestLength === 0) {
            return true;
        }

        return ($sharedWords / $shortestLength) < 0.6;
    }

    protected function sanitizeSuggestions(array $suggestions, string $question = ''): array
    {
        return collect($suggestions)
            ->map(fn ($suggestion) => trim((string) $suggestion))
            ->filter(fn ($suggestion) => $this->isUsefulSuggestion($suggestion, $question))
            ->unique(fn ($item) => $this->suggestionTopic((string) $item))
            ->take(4)
            ->values()
            ->all();
    }

    protected function suggestionTopic(string $suggestion): string
    {
        $normalized = $this->normalizeText($suggestion);
        $normalized = preg_replace('/^(?:view|open|tell me about|what is|what are|how do i|where can i)\s+/', '', $normalized) ?? $normalized;
        $words = $this->words($normalized);

        return implode(' ', array_slice($words, 0, 4));
    }

    protected function fallbackResponse(?string $question = null): array
    {
        return [
            'answer' => $question
                ? "I couldn’t find a reliable system entry for “{$question}.” Try mentioning the specific page, program, collection, service, facility, event, or form you need. For information not published on the website, please contact the library staff."
                : 'Ask me about a collection, academic program, service, facility, event, form, or website page.',
            'title' => 'Let me help you find it',
            'pageUrl' => url('/more/ask-librarian'),
            'suggestions' => $this->defaultSuggestions(),
        ];
    }

    protected function defaultSuggestions(): array
    {
        return [
            'Where can I find E-books for my program?',
            'What services and facilities are available?',
            'How do I contact the librarian?',
            'How do I reserve the AVR?',
        ];
    }

    protected function directIntentResponse(string $message): ?array
    {
        $libraryResponse = $this->libraryInformationResponse($message);

        if ($libraryResponse !== null) {
            return $libraryResponse;
        }

        $contactTerms = [
            'contact', 'email', 'gmail', 'mail', 'message', 'facebook',
            'phone', 'telephone', 'call', 'number', 'address', 'located',
            'location', 'reach', 'help desk',
        ];
        $libraryTerms = ['library', 'librarian', 'mmaci'];

        $isContactQuestion = Str::contains($message, $contactTerms)
            && Str::contains($message, $libraryTerms);

        if (! $isContactQuestion) {
            return null;
        }

        if (Str::contains($message, ['email', 'gmail', 'mail'])) {
            $answer = 'You can email the MMACI Library Services Office at mmacilibrary@mmacibutuan.edu.ph. You may also use the published Gmail address mmacilibrary@gmail.com.';
            $title = 'Contact MMACI Library';
        } elseif (Str::contains($message, ['phone', 'telephone', 'call', 'number'])) {
            $answer = 'You can contact the MMACI Library Services Office by phone at +63 948 553 2601. You may also email mmacilibrary@mmacibutuan.edu.ph.';
            $title = 'MMACI Library Contact Number';
        } elseif (Str::contains($message, ['address', 'located', 'location'])) {
            $answer = 'The MMACI Library Services Office is located at North Montilla Boulevard, Butuan City, Philippines. Open Ask the Librarian for the other contact channels.';
            $title = 'MMACI Library Location';
        } elseif (Str::contains($message, 'facebook')) {
            $answer = 'You can message MMACI Library on Facebook through the official MMACI Library page. You may also email mmacilibrary@mmacibutuan.edu.ph.';
            $title = 'MMACI Library Facebook';
        } else {
            $answer = 'You can reach the MMACI Library Services Office by email at mmacilibrary@mmacibutuan.edu.ph, by phone at +63 948 553 2601, or through the official MMACI Library Facebook page.';
            $title = 'Contact MMACI Library';
        }

        return [
            'answer' => $answer,
            'title' => $title,
            'pageUrl' => url('/more/ask-librarian'),
            'suggestions' => [
                'What is the library contact number?',
                'Where is the library located?',
                'How do I contact the library on Facebook?',
                'Open Ask the Librarian',
            ],
        ];
    }

    protected function libraryInformationResponse(string $message): ?array
    {
        $message = $this->normalizeText($message);

        if (Str::contains($message, ['calendar', 'upcoming activit', 'upcoming event', 'library event', 'library activit'])) {
            return $this->informationResponse(
                'Upcoming Library Activities',
                'You can view upcoming library activities on the Home page. Scroll to the News and events section to see the Upcoming Activities list and the Library Calendar.',
                '/',
                ['View library updates', 'Where are the new arrivals?', 'Open the gallery']
            );
        }

        if (Str::contains($message, ['what facilities', 'available facilities', 'facility available', 'library facilities', 'learning spaces'])) {
            return $this->informationResponse(
                'Available Library Facilities',
                'The MMACI Library facilities are: Discussion Room (up to 8 persons), Reading Area (54 persons), four Reading Cubicles (up to 8 persons per cubicle), Faculty Lounge (faculty only), and the Audio Visual Room or AVR (at least 100 people).',
                '/services/facilities',
                ['Discussion Room capacity', 'Reading Area capacity', 'Tell me about the AVR', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['what services', 'available services', 'service available', 'library services', 'services offer'])) {
            return $this->informationResponse(
                'Available Library Services',
                'The library offers the Online Public Access Catalog (OPAC) for finding materials, educational games such as chess and Scrabble, electronic laptop service for one-hour academic use, book borrowing, research assistance, and access to printed and digital collections.',
                '/services',
                ['How do I use OPAC?', 'How can I borrow a laptop?', 'What are the borrowing limits?', 'View Library Services']
            );
        }

        if (Str::contains($message, ['library hours', 'opening hours', 'open today', 'what time', 'closing time', 'schedule'])) {
            return $this->informationResponse(
                'Library Hours',
                'The library is open Monday to Friday from 8:00 AM to 9:00 PM and Saturday from 8:00 AM to 5:00 PM. It is closed on Sunday.',
                '/services',
                ['What services are available?', 'What facilities are available?', 'View Library Services']
            );
        }

        if (Str::contains($message, ['discussion room'])) {
            return $this->informationResponse(
                'Discussion Room',
                'The Discussion Room is a private space for brainstorming, collaborative learning, meetings, and group discussions. It accommodates up to 8 persons.',
                '/services/facilities',
                ['What facilities are available?', 'Tell me about the AVR', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['reading cubicle', 'reading cubicles'])) {
            return $this->informationResponse(
                'Reading Cubicles',
                'The library has four Reading Cubicles with electrical outlets for laptops and electronic devices. Each cubicle can accommodate up to 8 persons.',
                '/services/facilities',
                ['Reading Area capacity', 'What facilities are available?', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['reading area'])) {
            return $this->informationResponse(
                'Reading Area',
                'The Reading Area is a spacious, quiet place for reading, independent study, research, and academic work. It accommodates up to 54 library users.',
                '/services/facilities',
                ['Tell me about reading cubicles', 'What facilities are available?', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['faculty lounge'])) {
            return $this->informationResponse(
                'Faculty Lounge',
                'The Faculty Lounge is reserved for faculty members to read, prepare instructional materials, conduct consultations, and perform academic work.',
                '/services/facilities',
                ['What facilities are available?', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['avr', 'audio visual room']) && ! Str::contains($message, ['reserve', 'reservation', 'book'])) {
            return $this->informationResponse(
                'Audio Visual Room (AVR)',
                'The Audio Visual Room provides a larger space for classes and meetings and can accommodate at least 100 people. Use the Reserve AVR page to request it.',
                '/services/facilities',
                ['How do I reserve the AVR?', 'What facilities are available?', 'View Library Facilities']
            );
        }

        if (Str::contains($message, ['borrowing limit', 'borrow books', 'how many books', 'loan period', 'renew books'])) {
            return $this->informationResponse(
                'Book Borrowing',
                'Students may borrow up to 3 books for 2 days. Faculty members may borrow up to 10 books for 1 month. Both groups may renew borrowed books up to 2 times, subject to library policies.',
                '/services',
                ['What are the library hours?', 'What services are available?', 'View Library Services']
            );
        }

        if (Str::contains($message, ['opac', 'catalog search', 'find a book'])) {
            return $this->informationResponse(
                'Online Public Access Catalog (OPAC)',
                'Use OPAC to search library materials by title, author, subject, or keyword and check which resources are available.',
                '/services',
                ['What services are available?', 'How many books can I borrow?', 'View Library Services']
            );
        }

        if (Str::contains($message, ['borrow laptop', 'borrow a laptop', 'library laptop', 'laptop service', 'use laptop', 'use a laptop', 'electronic service'])) {
            return $this->informationResponse(
                'Electronic Laptop Service',
                'Library patrons may borrow a Library Services Office laptop for one hour for research and school-related work, subject to approval and availability.',
                '/services',
                ['What services are available?', 'What are the library hours?', 'View Library Services']
            );
        }

        return null;
    }

    protected function informationResponse(
        string $title,
        string $answer,
        string $path,
        array $suggestions
    ): array {
        return [
            'answer' => $answer,
            'title' => $title,
            'pageUrl' => url($path),
            'suggestions' => $suggestions,
        ];
    }

    protected function varyAnswer(string $answer, int $historyCount): string
    {
        $prefixes = ['', 'Here’s what I found: ', 'Based on the library website: '];
        return $prefixes[$historyCount % count($prefixes)].$answer;
    }

    protected function publicFacingAnswer(string $answer): string
    {
        $replacements = [
            '/\\badmins?\\b/i' => 'authorized staff',
            '/\\badmin panel\\b/i' => 'website management area',
            '/\\badmins can\\b/i' => 'authorized staff can',
        ];

        foreach ($replacements as $pattern => $replacement) {
            $answer = preg_replace($pattern, $replacement, $answer) ?? $answer;
        }

        return preg_replace('/\\s+/', ' ', trim($answer)) ?? trim($answer);
    }

    protected function isGreeting(string $message): bool
    {
        return in_array($message, ['hi', 'hello', 'hey', 'good morning', 'good afternoon', 'good evening'], true);
    }

    protected function normalizeText(string $text): string
    {
        $text = Str::lower($text);
        $text = preg_replace('/[^\\pL\\pN\\s-]+/u', ' ', $text) ?? $text;
        return preg_replace('/\\s+/', ' ', trim($text)) ?? trim($text);
    }

    protected function words(string $text): array
    {
        $stopWords = ['a', 'an', 'the', 'is', 'are', 'was', 'were', 'do', 'does', 'did', 'how', 'where', 'what', 'which', 'can', 'could', 'i', 'me', 'my', 'to', 'of', 'for', 'in', 'on', 'at', 'and', 'or', 'please'];

        return collect(explode(' ', $this->normalizeText($text)))
            ->filter(fn ($word) => mb_strlen($word) >= 2 && ! in_array($word, $stopWords, true))
            ->unique()
            ->values()
            ->all();
    }
}
