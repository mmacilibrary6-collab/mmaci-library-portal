<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\View\View;

class MoreController extends Controller
{
    private const FACEBOOK_URL =
        'https://www.facebook.com/MMACILibrary/';

    private const YOUTUBE_URL =
        'https://www.youtube.com/channel/UC9wkl5BvNXqhxQgYi8WP3ig';

    private const SATISFACTION_SURVEY_URL =
        'https://docs.google.com/forms/d/e/1FAIpQLSedbW1FN9CIQ8-vFvwqcEptpBHOtObKgHks_34kz7_3nheTTA/viewform';

    private const VISITING_RESEARCHER_FORM_URL =
        'https://docs.google.com/forms/d/e/1FAIpQLSeKuNcoNY5ndVnlJfsFyjjM96t7Ga5FBz00MAT6gSM2KHOhTQ/viewform';

    /**
     * Display the Ask the Librarian page.
     */
    public function askLibrarian(): View
    {
        $contactInformation = [
            [
                'title' => 'Facebook',
                'value' => 'MMACI Library',
                'icon' => 'bi-facebook',
                'url' => self::FACEBOOK_URL,
            ],
            [
                'title' => 'Email',
                'value' => 'mmacilibrary@gmail.com',
                'icon' => 'bi-envelope-fill',
                'url' => 'mailto:mmacilibrary@gmail.com',
            ],
            [
                'title' => 'YouTube',
                'value' => 'MMACI Library Channel',
                'icon' => 'bi-youtube',
                'url' => self::YOUTUBE_URL,
            ],
        ];

        $tutorials = [
            [
                'title' => 'Access Free E-Books',
                'description' =>
                    'Learn how to browse and access the free electronic books available through the MMACI Library Services Office.',
                'icon' => 'bi-laptop',
                'url' => route('collection.ebooks'),
            ],
        ];

        return view('more.ask-librarian', [
            'contactInformation' => $contactInformation,
            'tutorials' => $tutorials,
            'satisfactionSurveyUrl' => self::SATISFACTION_SURVEY_URL,
            'visitingResearcherFormUrl' => self::VISITING_RESEARCHER_FORM_URL,
        ]);
    }

    /**
     * Display the public gallery page.
     */
    public function gallery(): View
    {
        $galleries = Gallery::query()
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        return view('more.gallery', [
            'galleries' => $galleries,
        ]);
    }

    /**
     * Display the visiting researchers page.
     */
    public function visitingUsers(): View
    {
        $steps = [
            [
                'title' => 'Complete the Appointment Form',
                'description' =>
                    'Submit the online appointment form before your visit. Walk-in researchers may also be accommodated during regular library hours.',
                'icon' => 'bi-clipboard-check-fill',
            ],
            [
                'title' => 'Identify the Resources You Need',
                'description' =>
                    'Provide information about the books, journals, or research materials required for your study.',
                'icon' => 'bi-search',
            ],
            [
                'title' => 'Confirm Resource Availability',
                'description' =>
                    'The librarian will verify whether the requested materials are currently available for use.',
                'icon' => 'bi-check-circle-fill',
            ],
            [
                'title' => 'Use the Library Materials',
                'description' =>
                    'Once confirmed, you may use the available resources according to the library’s policies and applicable fees.',
                'icon' => 'bi-file-earmark-check-fill',
            ],
        ];

        return view('more.visiting-users', [
            'appointmentFormUrl' => self::VISITING_RESEARCHER_FORM_URL,
            'steps' => $steps,
        ]);
    }
}
