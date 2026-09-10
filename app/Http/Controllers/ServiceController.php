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
                'image' => 'images/Opacc.jpg',
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
                'image' => 'images/chesz.jpg',
                'icon' => 'bi-controller',
                'description' => 'Educational and recreational board games are available for library users during approved library hours.',
                'features' => [
                    'Chess',
                    'Scrabble',
                ],
            ],
            [
                'title' => 'Circulation',
                'image' => 'images/facilities/circulation-area.webp',
                'icon' => 'bi-arrow-left-right',
                'description' => 'Assists users with borrowing, returning, and renewing library books and other materials.',
            ],
            [
                'title' => 'Reference & Research Assistance',
                'image' => 'images/facilities/reference-section.webp',
                'icon' => 'bi-journal-bookmark-fill',
                'description' => 'Helps students find reliable information and appropriate resources for their research and assignments.',
            ],
            [
                'title' => 'E-Resources & Online Databases',
                'image' => 'images/facilities/e-library.webp',
                'icon' => 'bi-pc-display-horizontal',
                'description' => 'Provides access to e-books, online journals, research articles, and other digital resources.',
            ],
            [
                'title' => 'Periodical Services',
                'image' => 'images/facilities/periodical-section.webp',
                'icon' => 'bi-newspaper',
                'description' => 'Provides access to newspapers, magazines, journals, and other regularly published materials.',
            ],
            [
                'title' => 'Interlibrary Loan',
                'image' => 'images/librarycollect.jpg',
                'icon' => 'bi-share-fill',
                'description' => 'Allows users to request books and other materials that are not available in the library from other libraries.',
            ],
            [
                'title' => 'Library Orientation',
                'image' => 'images/facilities/library-orientation.png',
                'icon' => 'bi-compass-fill',
                'description' => 'Introduces students to the library, its facilities, collections, rules, and available services.',
            ],
            [
                'title' => 'Information Literacy',
                'image' => 'images/Studentslib2.jpg',
                'icon' => 'bi-lightbulb-fill',
                'description' => 'Teaches students how to search, evaluate, use, and properly cite information from reliable sources.',
            ],
            [
                'title' => 'Scanning',
                'image' => 'images/libraryservicess.webp',
                'icon' => 'bi-upc-scan',
                'description' => 'Provides scanning services for library materials and documents for academic and research purposes.',
            ],
            [
                'title' => 'Thesis & Special Collections',
                'image' => 'images/thesis.jpg',
                'icon' => 'bi-mortarboard-fill',
                'description' => 'Provides access to theses, research papers, and other special or unique library collections.',
            ],
            [
                'title' => 'Referral Services',
                'image' => 'images/Doors.webp',
                'icon' => 'bi-signpost-split-fill',
                'description' => 'Directs users to other libraries, institutions, or resources when the needed information or material is not available in the library.',
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
                'description' => 'A designated room where students can work together, discuss lessons, and conduct group activities.',
            ],
            [
                'title' => 'Reading Area',
                'image' => asset(
                    'images/facilities/reading-area.jpg'
                ),
                'icon' => 'bi-book-half',
                'capacity' => '54 Persons',
                'description' => 'A quiet and comfortable space where students can read, study, and do their schoolwork.',
            ],
            [
                'title' => 'E-Library',
                'image' => asset(
                    'images/facilities/e-library.webp'
                ),
                'icon' => 'bi-pc-display-horizontal',
                'description' => 'A space where students can access electronic resources such as e-books, online journals, databases, and other digital learning materials.',
            ],
            [
                'title' => 'Periodical Section',
                'image' => asset(
                    'images/facilities/periodical-section.webp'
                ),
                'icon' => 'bi-newspaper',
                'description' => 'A section that provides newspapers, magazines, journals, and other regularly published materials.',
            ],
            [
                'title' => 'Reference Section',
                'image' => asset(
                    'images/facilities/reference-section.webp'
                ),
                'icon' => 'bi-journal-bookmark-fill',
                'description' => 'A section that contains books and resources used for finding specific information, such as dictionaries, encyclopedias, atlases, and other reference materials.',
            ],
            [
                'title' => 'Thesis & Research Area',
                'image' => asset(
                    'images/thesis.jpg'
                ),
                'icon' => 'bi-mortarboard-fill',
                'description' => 'A designated space where students can access theses, research papers, and other academic materials for their research and study.',
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
