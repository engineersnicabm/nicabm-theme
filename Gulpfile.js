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
        version: pkg.version,
        license: pkg.license,
        textdomain: pkg.name
    },
    js: {
        'theme' : [
            'develop/vendor/a.js',
            'develop/js/b.js'
        ],
        'something-conditional' : [
            'develop/js/standalone.js'
        ]
    }
});

toolkit.extendTasks(gulp, { /* Task Overrides */ });
