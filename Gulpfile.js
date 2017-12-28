'use strict';

var gulp = require('gulp'),
    pkg = require('./package.json'),
    toolkit = require('gulp-wp-toolkit');

toolkit.extendConfig({
    theme: {
        name: "NICABM Theme",
        homepage: pkg.homepage,
        description: pkg.description,
        author: pkg.author,
        template: pkg.template,
        version: pkg.version,
        license: pkg.license,
        textdomain: pkg.name
    },
    js: {
        'theme' : [
            'develop/js/fadeup.js',
            'develop/js/global.js'
        ],
        'front-page' : [
            'develop/js/home.js',
            'develop/js/jquery.localScroll.min.js',
            'develop/js/jquery.scrollTo.min.js'
        ],
        'parallax' : [
            'develop/js/parallax.js'
        ]
    },
    server: {
        url: 'nicabm.local'
    },
    css: {
        basefontsize: 10, // Used by postcss-pxtorem.
        remmediaquery: false
    }
});

toolkit.extendTasks(gulp, { /* Task Overrides...none at this time */ });
