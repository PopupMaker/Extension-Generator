var gulp = require('gulp'),
    replace = require('gulp-replace-task'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    $ = gulpLoadPlugins(),
    options = {
        name: 'Exit Intent Popups',
        slug: 'popup-maker-exit-intent-popups',
        url: 'https://wppopupmaker.com/extensions/exit-intent-popups/',
        description: 'Awesomeness!',
        author: 'Daniel Iser',
        author_url: 'https://wppopupmaker.com/',
        packages: []
    };

gulp.task('questions', function () {
    $.util.log('Welcome to the Popup Maker Extension Boilerplate.');
    $.util.log('Please answer the following questions to get started quickly...');
    return gulp.src('plugin-name/**/*.*')
        .pipe($.prompt.prompt([
            {
                type: 'input',
                name: 'name',
                message: 'Name: ',
                validate: function(input) {
                    if (typeof input !== "string" || input === '') {
                        return "Please enter a valid name.";
                    }
                    return true;
                }
            },
            {
                type: 'input',
                name: 'slug',
                message: 'Slug: ',
                validate: function(input) {
                    if (typeof input !== "string" || input === '') {
                        return "Please enter a valid slug.";
                    }
                    return true;
                }
            },
            {
                type: 'input',
                name: 'url',
                message: 'URL: '
            },
            {
                type: 'input',
                name: 'description',
                message: 'Description: '
            },
            {
                type: 'input',
                name: 'author',
                message: 'Author Name: '
            },
            {
                type: 'input',
                name: 'author_url',
                message: 'Author URL: '
            },
            {
                type: 'checkbox',
                name: 'packages',
                message: 'Choose which packages to include:',
                choices: [
                    {
                        name: "Triggers"
                    },
                    {
                        name: "Targeting Conditions"
                    },
                    {
                        name: "Global Settings"
                    },
                    {
                        name: "Layouts"
                    },
                    {
                        name: "Popup Settings"
                    },
                    {
                        name: "Theme Settings"
                    }
                ]
            }
        ], function(res){
            options = res;
            $.util.log(options);
    }));
});

gulp.task('build', ['questions'], function () {
    $.util.log('Starting build for "' + options.name + '"...');
    var stream1 = gulp.src('plugin-name/plugin-name.php')
        .pipe(replace({
            //usePrefix: false,
            patterns: [
                {
                    match: 'name',
                    replacement: options.name
                },
                {
                    match: 'url',
                    replacement: options.url
                },
                {
                    match: 'description',
                    replacement: options.description
                },
                {
                    match: 'author',
                    replacement: options.author
                },
                {
                    match: 'author_url',
                    replacement: options.author_url
                },
                {
                    match: 'text_domain',
                    replacement: options.slug
                },
                {
                    match: 'classname',
                    replacement: options.name.replace(/ /g, '_')
                },
                {
                    match: 'package',
                    replacement: options.name.replace(/ /g, '')
                },
                {
                    match: 'constant',
                    replacement: options.name.toUpperCase().replace(/ /g, '_')
                },
                {
                    match: 'prefix',
                    replacement: options.name.toLowerCase().replace(/ /g, '_')
                },
                {
                    match: 'year',
                    replacement: new Date().getYear()
                }
            ]
        }))
        .pipe($.rename({basename: options.slug}))
        .pipe(gulp.dest(options.slug));

    return stream1;
});

