<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display the library services page.
     */
    public function services(): View
    {
        $serviceHours = [
            [
                'days' => 'Monday to Friday',
                'opening' => '8:00 AM',
                'closing' => '9:00 PM',
                'status' => 'Open',
            ],
            [
                'days' => 'Saturday',
                'opening' => '8:00 AM',
                'closing' => '5:00 PM',
                'status' => 'Open',
            ],
            [
                'days' => 'Sunday',
                'opening' => null,
                'closing' => null,
                'status' => 'Closed',
            ],
        ];

        $rules = [
            'Leave personal belongings at the designated baggage area.',
            'Faculty members and students must sign in through the monitoring system upon entering the library.',
            'Food and drinks are not allowed inside the library.',
            'Library materials must not be taken outside the library without permission from the Circulation In-Charge.',
            'Handle all library materials with care.',
            'Do not return books directly to the shelves to prevent them from being misplaced.',
            'Books used in the reading areas must be left on the tables after use.',
            'Chairs must be pushed back under the tables after use and must not be transferred from one place to another.',
            'Headphones may be used with personal stereos, laptops, or mobile phones, provided that the volume does not disturb other library users.',
            'Watching movies or videos for leisure is not allowed inside the library.',
        ];

        $studentBorrowingPolicies = [
            'Students may borrow up to three (3) books at a time.',
            'Books may be borrowed for two (2) days.',
            'Borrowed books may be renewed up to two (2) times.',
            'A fine will be imposed when borrowed books are not returned or renewed on time.',
        ];

        $facultyBorrowingPolicies = [
            'Faculty members may borrow up to ten (10) books at a time.',
            'Books may be borrowed for one (1) month.',
            'Borrowed books may be renewed up to two (2) times.',
            'A fine will be imposed when borrowed books are not returned or renewed on time.',
        ];

        $services = [
            [
                'title' => 'Online Public Access Catalog',
                'short_title' => 'OPAC',
                'icon' => 'bi-search',
                'description' => 'The Online Public Access Catalog allows library users to search for books and other library materials using the internet.',
                'features' => [
                    'Search library materials by title',
                    'Search by author',
                    'Search by subject or keyword',
                    'Check available library resources',
                ],
            ],
            [
                'title' => 'Educational Games',
                'short_title' => 'Games',
                'icon' => 'bi-controller',
                'description' => 'Educational and recreational board games are available for library users during approved library hours.',
                'features' => [
                    'Chess',
                    'Scrabble',
                ],
            ],
            [
                'title' => 'Electronic Service',
                'short_title' => 'Electronic Service',
                'icon' => 'bi-laptop',
                'description' => 'Library patrons may borrow a Library Services Office laptop for one hour to conduct research and complete school-related work.',
                'features' => [
                    'One-hour laptop use',
                    'For research activities',
                    'For school-related work',
                    'Subject to laptop availability',
                ],
            ],
        ];

        return view(
            'services.index',
            compact(
                'serviceHours',
                'rules',
                'studentBorrowingPolicies',
                'facultyBorrowingPolicies',
                'services'
            )
        );
    }

    /**
     * Display the library facilities page.
     */
    public function facilities(): View
    {
        $facilities = [
            [
                'title' => 'Discussion Room',
                'image' => asset(
                    'images/facilities/discussion-room.jpg'
                ),
                'icon' => 'bi-people-fill',
                'capacity' => 'Up to 8 Persons',
                'description' => 'The Discussion Room is a private space intended for brainstorming sessions, collaborative learning, meetings, and group discussions. It provides a quiet and comfortable environment that can accommodate up to eight (8) persons.',
            ],
            [
                'title' => 'Reading Area',
                'image' => asset(
                    'images/facilities/reading-area.jpg'
                ),
                'icon' => 'bi-book-half',
                'capacity' => '54 Persons',
                'description' => 'The Reading Area provides a spacious and quiet environment where students can read books, study independently, conduct research, and complete academic requirements. The area accommodates up to fifty-four (54) library users.',
            ],
            [
                'title' => 'Reading Cubicles',
                'image' => asset(
                    'images/facilities/reading-cubicles.jpg'
                ),
                'icon' => 'bi-laptop',
                'capacity' => '8 Persons per Cubicle',
                'description' => 'The library has four (4) Reading Cubicles equipped with electrical outlets for students using laptops and other electronic devices. Each cubicle comfortably accommodates up to eight (8) persons.',
            ],
            [
                'title' => 'Faculty Lounge',
                'image' => asset(
                    'images/facilities/faculty-lounge.jpg'
                ),
                'icon' => 'bi-person-workspace',
                'capacity' => 'Faculty Only',
                'description' => 'The Faculty Lounge is an exclusive space where faculty members can read, prepare instructional materials, conduct consultations, and perform academic work in a quiet environment.',
            ],
            [
                'title' => 'Audio Visual Room (AVR)',
                'image' => asset('images/AVR.jpg'),
                'icon' => 'bi-play-btn-fill',
                'capacity' => 'At least 100 people',
                'description' => 'The AVR is a place to provide bigger space to the large number of people to hold their classes or meetings. The AVR can accommodate at least 100 people.',
            ],
        ];

        return view(
            'services.facilities',
            compact('facilities')
        );
    }
}
