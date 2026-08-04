<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LisaAssistant
{
    /**
     * Produce a free, local response without any external API.
     */
    public function reply(string $message): array
    {
        $message = trim(Str::lower($message));

        $entries = $this->knowledgeEntries();
        $bestMatch = null;
        $bestScore = 0;

        foreach ($entries as $entry) {
            $score = $this->score($message, $entry['keywords'] ?? []);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $entry;
            }
        }

        if ($bestMatch && $bestScore > 0) {
            return [
                'answer' => $this->publicFacingAnswer($bestMatch['answer']),
                'title' => $bestMatch['title'],
                'suggestions' => $bestMatch['suggestions'] ?? [],
                'pageUrl' => $bestMatch['pageUrl'] ?? null,
            ];
        }

        return [
            'answer' => "I can help with the MMACI Library website, public collection pages, services, reservations, and site content. Try asking about E-books, thesis folders, gallery uploads, the Reserve AVR form, or how to find a page.",
            'title' => 'Need a quick guide?',
            'pageUrl' => null,
            'suggestions' => [
                'How do I open the E-books page?',
                'Where do I reserve the AVR?',
                'How do gallery uploads work?',
            ],
        ];
    }

    protected function score(string $message, array $keywords): int
    {
        $score = 0;

        foreach ($keywords as $keyword) {
            $keyword = Str::lower($keyword);

            if ($keyword !== '' && Str::contains($message, $keyword)) {
                $score += 3;
            }
        }

        return $score;
    }

    protected function knowledgeEntries(): array
    {
        return Cache::remember('lisa.knowledge.entries.v2', now()->addMinutes(10), function () {
            $entries = [
                [
                    'title' => 'Home page',
                    'keywords' => ['home', 'homepage', 'landing page'],
                    'answer' => 'The Home page introduces the MMACI Library Services Office and links to the main sections of the site.',
                    'pageUrl' => url('/'),
                    'suggestions' => ['Show me the collection pages', 'What can I find on the homepage?'],
                ],
                [
                    'title' => 'About page',
                    'keywords' => ['about', 'mission', 'vision', 'history'],
                    'answer' => 'The About page gives visitors a quick overview of the library and institution, including the identity and purpose of the MMACI Library Services Office.',
                    'pageUrl' => url('/about'),
                    'suggestions' => ['Tell me what the About page covers', 'Where is the institution information?'],
                ],
                [
                    'title' => 'E-books',
                    'keywords' => ['ebook', 'e-book', 'e books', 'electronic books', 'collection ebooks'],
                    'answer' => 'The E-books section is organized by academic program. Each program contains folders with Google Drive links for downloadable or browsable e-book resources, and each program card opens a modal with the available folders.',
                    'pageUrl' => url('/collection/ebooks'),
                    'suggestions' => ['How do I add an ebook folder?', 'Can I search e-books by program?'],
                ],
                [
                    'title' => 'Thesis and dissertation',
                    'keywords' => ['thesis', 'dissertation', 'theses', 'thesis and dissertation'],
                    'answer' => 'The Thesis & Dissertation area is organized by academic program. Each program contains folder links to research materials and manuscripts, with the same program-and-folder structure used by E-books.',
                    'pageUrl' => url('/collection/theses'),
                    'suggestions' => ['How do thesis folders work?', 'Where are the thesis images stored?'],
                ],
                [
                    'title' => 'Periodicals',
                    'keywords' => ['periodical', 'periodicals', 'journal', 'newspaper', 'magazine', 'periodical collection'],
                    'answer' => 'The Periodical Collection is grouped by program, and the folders inside each program are categorized as Journal & Newspaper Clippings or Magazines. The public page also supports category filtering.',
                    'pageUrl' => url('/collection/periodicals'),
                    'suggestions' => ['Can I filter periodicals by category?', 'How do periodical folders work?'],
                ],
                [
                    'title' => 'Donated books',
                    'keywords' => ['donated books', 'donation', 'donated', 'gifted books'],
                    'answer' => 'Donated Books shows donated titles with descriptions and images, using the same public design style as the other collection pages, with card layouts and placeholder-safe imagery.',
                    'pageUrl' => url('/collection/donated-books'),
                    'suggestions' => ['How do I add donated books in admin?', 'What image format should I upload?'],
                ],
                [
                    'title' => 'Open access resources',
                    'keywords' => ['open access', 'opac', 'public access', 'catalog', 'online public access catalog'],
                    'answer' => 'Open Access Resources and OPAC-related pages display resource cards and links for public browsing and research support. Broken images there usually mean the uploaded image path needs to be refreshed or re-saved.',
                    'pageUrl' => url('/collection/open-access'),
                    'suggestions' => ['Why is an image broken?', 'How do I update an open access resource?'],
                ],
                [
                    'title' => 'Subscribed online database',
                    'keywords' => ['ebsco', 'database', 'subscribed online database', 'online database'],
                    'answer' => 'Subscribed Online Database opens the EBSCO login access provided by the library, and users should follow the circulation staff instructions for credentials. The page now appears as an embedded public resource section instead of a plain link.',
                    'pageUrl' => url('/collection/subscribed-database'),
                    'suggestions' => ['Where do I get login credentials?', 'Can I embed the database page?'],
                ],
                [
                    'title' => 'Reserve AVR',
                    'keywords' => ['reserve avr', 'avr', 'audio visual room', 'reservation'],
                    'answer' => 'Reserve AVR is a public form page where users can request the Audio Visual Room for classes or meetings. The form is embedded directly on the page and the section uses the same polished layout as Online Book Recommendation.',
                    'pageUrl' => url('/more/reserve-avr'),
                    'suggestions' => ['How do I reserve the AVR?', 'What is the AVR capacity?'],
                ],
                [
                    'title' => 'Gallery',
                    'keywords' => ['gallery', 'photos', 'albums', 'slideshow', 'gallery folders'],
                    'answer' => 'The Gallery page shows public photo folders in a slideshow-style viewer. Admins can create folders and upload images for each event or album, and the public viewer rotates through the uploaded photos.',
                    'pageUrl' => url('/more/gallery'),
                    'suggestions' => ['How do gallery uploads work?', 'Can I add multiple photos?'],
                ],
                [
                    'title' => 'Ask the Librarian',
                    'keywords' => ['ask librarian', 'ask the librarian', 'contact'],
                    'answer' => 'Ask the Librarian provides contact options and support links for users who need help from library staff. It includes Facebook, email, and video/tutorial-style support items.',
                    'pageUrl' => url('/more/ask-librarian'),
                    'suggestions' => ['How do I contact the library?', 'Where is the Facebook page linked?'],
                ],
                [
                    'title' => 'Public services',
                    'keywords' => ['services', 'facilities', 'reading', 'discussion room', 'laptop access', 'book borrowing'],
                    'answer' => 'The Services & Facilities pages list the spaces and resources available to the MMACI community, including reading areas, discussion rooms, laptop access, and other shared spaces. The layouts are designed to stay mobile-friendly.',
                    'pageUrl' => url('/services'),
                    'suggestions' => ['What facilities are available?', 'How can I reserve a room?'],
                ],
                [
                    'title' => 'Admin dashboard',
                    'keywords' => ['admin', 'dashboard', 'management', 'calendar events', 'new arrivals', 'library updates'],
                    'answer' => 'The site management area supports calendar events, arrivals, gallery folders, library updates, e-books, theses, periodicals, donated books, and other content used across the website.',
                    'pageUrl' => null,
                    'suggestions' => ['How do I upload an image?', 'Why are duplicate messages showing?'],
                ],
                [
                    'title' => 'Navigation',
                    'keywords' => ['menu', 'navbar', 'footer', 'navigation'],
                    'answer' => 'The site navigation groups public pages into Collection, Services & Facilities, and More. The footer and navbar both point to the same public destinations for quick access.',
                    'pageUrl' => url('/'),
                    'suggestions' => ['What is inside the More menu?', 'Where are the collection links?'],
                ],
                [
                    'title' => 'Home highlights',
                    'keywords' => ['library updates', 'new arrivals', 'featured video', 'news and events', 'calendar'],
                    'answer' => 'The Home page highlights news and events, library updates, new arrivals, a gallery preview, and a featured video, all arranged in the main landing layout.',
                    'pageUrl' => url('/'),
                    'suggestions' => ['What shows on the homepage?', 'Where do library updates appear?'],
                ],
            ];

            return array_merge($entries, $this->scannedEntries());
        });
    }

    protected function scannedEntries(): array
    {
        $viewsPath = resource_path('views');

        if (! File::isDirectory($viewsPath)) {
            return [];
        }

        $excludedDirectories = [
            'admin/',
            'auth/',
            'components/',
            'emails/',
            'layouts/',
            'partials/',
            'vendor/',
        ];

        $paths = collect(File::allFiles($viewsPath))
            ->filter(function ($file) use ($viewsPath, $excludedDirectories) {
                $relativePath = Str::of($file->getPathname())
                    ->after(rtrim($viewsPath, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR)
                    ->replace('\\', '/')
                    ->toString();

                if (! Str::endsWith($relativePath, '.blade.php')) {
                    return false;
                }

                return ! collect($excludedDirectories)
                    ->contains(fn (string $directory) => Str::startsWith($relativePath, $directory));
            })
            ->map(fn ($file) => $file->getPathname())
            ->values()
            ->all();

        $entries = [];

        foreach ($paths as $path) {
            if (! File::exists($path)) {
                continue;
            }

            $contents = File::get($path);
            $title = $this->extractTitle($contents) ?: Str::headline(basename($path, '.blade.php'));
            $snippets = $this->extractSnippets($contents);

            $keywords = array_filter(array_unique(array_merge(
                [Str::lower($title)],
                $snippets['keywords']
            )));

            $answer = $snippets['answer'] ?: "The {$title} page is available on the public site and follows the MMACI Library design system.";
            $pageUrl = $this->guessPageUrl($path);

            $entries[] = [
                'title' => $title,
                'keywords' => $keywords,
                'answer' => $this->publicFacingAnswer($answer),
                'pageUrl' => $pageUrl,
                'suggestions' => $snippets['suggestions'],
            ];
        }

        return $entries;
    }

    protected function extractTitle(string $contents): ?string
    {
        if (preg_match('/@section\\([\'"]title[\'"]\\s*,\\s*[\'"]([^\'"]+)[\'"]\\)/', $contents, $matches)) {
            return trim($matches[1]);
        }

        if (preg_match('/<h1[^>]*>(.*?)<\\/h1>/si', $contents, $matches)) {
            return trim(strip_tags($matches[1]));
        }

        return null;
    }

    protected function extractSnippets(string $contents): array
    {
        $keywords = [];
        $suggestions = [];

        if (preg_match_all('/<h[12][^>]*>(.*?)<\\/h[12]>/si', $contents, $matches)) {
            foreach ($matches[1] as $heading) {
                $text = trim(strip_tags($heading));
                if ($text !== '') {
                    $keywords[] = Str::lower($text);
                }
            }
        }

        if (preg_match_all('/<p[^>]*>(.*?)<\\/p>/si', $contents, $matches)) {
            foreach (array_slice($matches[1], 0, 3) as $paragraph) {
                $text = trim(preg_replace('/\\s+/', ' ', strip_tags($paragraph)));
                if ($text !== '') {
                    $suggestions[] = Str::of($text)->limit(110)->toString();
                }
            }
        }

        return [
            'keywords' => array_slice($keywords, 0, 8),
            'suggestions' => array_slice($suggestions, 0, 3),
            'answer' => $suggestions[0] ?? null,
        ];
    }

    protected function guessPageUrl(string $path): ?string
    {
        $relative = Str::of($path)
            ->after(resource_path('views').DIRECTORY_SEPARATOR)
            ->replace('\\', '/')
            ->replace('.blade.php', '')
            ->toString();

        $map = [
            'home' => url('/'),
            'welcome' => url('/'),
            'about' => url('/about'),
            'collection/printed' => url('/collection/printed'),
            'collection/ebooks' => url('/collection/ebooks'),
            'collection/open-access' => url('/collection/open-access'),
            'collection/theses' => url('/collection/theses'),
            'collection/donated-books' => url('/collection/donated-books'),
            'collection/periodicals' => url('/collection/periodicals'),
            'collection/subscribed-database' => url('/collection/subscribed-database'),
            'more/gallery' => url('/more/gallery'),
            'more/online-book-recommendation' => url('/more/online-book-recommendation'),
            'more/reserve-avr' => url('/more/reserve-avr'),
            'more/visiting-users' => url('/more/visiting-users'),
            'more/ask-librarian' => url('/more/ask-librarian'),
            'services/index' => url('/services'),
            'services/facilities' => url('/services/facilities'),
        ];

        return $map[$relative] ?? null;
    }

    protected function publicFacingAnswer(string $answer): string
    {
        $replacements = [
            '/\badmin(?:s)?\b/i' => 'site team',
            '/\badmin workflows?\b/i' => 'site management',
            '/\badmin panel\b/i' => 'site management area',
            '/\badmins can\b/i' => 'the site team can',
            '/\bcan do\b/i' => 'can manage',
        ];

        foreach ($replacements as $pattern => $replacement) {
            $answer = preg_replace($pattern, $replacement, $answer) ?? $answer;
        }

        return preg_replace('/\s+/', ' ', trim($answer)) ?? $answer;
    }
}
