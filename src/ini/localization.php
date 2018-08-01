<?php
$GLOBALS["messages"] = array(
    'English' => array(
        'Home' => 'Home',
        'Profile' => 'Profile',
        'Game' => 'Game',
        'English' => 'English',
        'Hindi' => 'Hindi',
        'Search' => 'Search',
        'Welcome' => 'Welcome',
        'Friends' => 'Friends',
        'Messages' => 'Messages',
        'Logout and Return' => 'Logout and Return'
    ),
    'Hindi' => array(
        'Home' => 'होम',
        'Profile' => 'प्रोफ़ाइल',
        'Game' => 'खेल',
        'English' => 'अंग्रेज़ी',
        'Hindi' => 'हिंदी',
        'Search' => 'खोज',
        'Welcome' => 'स्वागत हे',
        'Friends' => 'दोस्त',
        'Messages' => 'संदेश',
        'Logout and Return' => 'लॉग आउट करने और छोड़ने'
    )
);

function msg($s) {
    $locale = $_SERVER[ 'QUERY_STRING' ];
    if (isset($GLOBALS["messages"][$locale][$s])) {
        return $GLOBALS["messages"][$locale][$s];
    } else {
        error_log("error: locale: "."$locale, message:'$s'");
    }
}

?>