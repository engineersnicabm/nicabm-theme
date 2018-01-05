'use strict';

var gulp = require('gulp'),
    pkg = require('./package.json'),
    toolkit = require('gulp-wp-toolkit');

toolkit.extendConfig({
    theme: {
        name: pkg.theme.name,
        themeuri: pkg.homepage,
        description: pkg.theme.description,
        author: pkg.author,
        authoruri: pkg.theme.authoruri,
        version: pkg.version,
        license: pkg.license,
        licenseuri: pkg.theme.licenseuri,
        tags: pkg.theme.tags,
        textdomain: pkg.name,
        domainpath: pkg.theme.domainpath,
        template: pkg.theme.template,
        notes: pkg.theme.notes
    },
    js: {
        'theme' : [
            'develop/js/fadeup.js',
            'develop/js/global.js'
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
