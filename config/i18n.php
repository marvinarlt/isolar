<?php

return [

    /**
     * Locale
     * ------
     * 
     * Here you can set the default locale for the project.
     * This is helpful if you want to change the default
     * language for your project.
     * Please use the ISO 3166-1 alpha-2 standard.
     * 
     */
    'locale' => 'en',

    /**
     * Directory
     * ---------
     * 
     * Sets the directory for the translation files.
     * The file names for the translation files should
     * be equal to the ISO standard.
     * 
     */
    'directory' => dirname(__DIR__) . '/resource/translation',

    /**
     * Avaible Translations
     * --------------------
     * 
     * Add new translations to this array.
     * This should be equal to the file name and the
     * ISO standard.
     * 
     */
    'avaible' => ['en', 'de'],

];