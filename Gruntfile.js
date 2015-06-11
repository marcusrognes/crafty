module.exports = function(grunt) {
    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // Comile the SCSS files.
        sass: {
            options: {
                includePaths: [
                    'bower_components/foundation/scss',
                    'bower_components/components-font-awesome/scss',
                ],
                outputStyle: 'nested', // 'compressed',
                imagePath: '/images/',
                sourceComments: 'map', // 'none', 'normal', 'map'
                sourceMap: true
            },
            dist: {
                files: {
                    'css/app.css': 'scss/app.scss',
                    'css/editor-style.css': 'scss/editor-style.scss'
                }
            }
        },

        // Concatenate the JS files.
        concat: {
            options: {
                stripBanners: false,
                sourceMap: true,
            },
            dist: {
                src: ['bower_components/modernizr/modernizr.js',
                    'bower_components/foundation/js/foundation.js',
                    'bower_components/foundation/js/foundation.topbar.js',
                    // 'bower_components/foundation/js/foundation.equalizer.js',
                    'bower_components/slick.js/slick/slick.min.js',
                    'bower_components/jquery.countdown/dist/jquery.countdown.min.js',
                    'js/instafeed.min.js',
                    'js/classie.js',
                    'js/modules.js',
                    'js/webfonts.js',
                    'js/skip-link-focus-fix.js',
                    // 'js/navigation.js',
                    'js/custom.js'],
                dest: 'js/app.js',
            }
        },

        // Minify the JS files.
        uglify: {
            build: {
                src: 'js/app.js',
                dest: 'js/app.min.js'
            }
        },

        // Move files and fonts to correct folders
        copy: {
            main: {
                files: [
                    {
                        expand: true,
                        cwd: 'bower_components/slick.js/slick/fonts/',
                        src: '**',
                        dest: 'fonts/',
                        flatten: true,
                        filter: 'isFile',
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/slick.js/slick/',
                        src: 'ajax-loader.gif',
                        dest: 'images/',
                        flatten: true,
                        filter: 'isFile',
                    },
                ],
            },
        },

        // Watch for changes in JS and SCSS files .
        // Concatenate and minify the JS Files.
        // Compile the SCSS files and live reload the browser.
        watch: {
            grunt: {
                files: ['Gruntfile.js']
            },

            scripts: {
                files: ['js/*.js'],
                tasks: ['concat', 'uglify'],
                options: {
                    spawn: false,
                },
            },

            sass: {
                files: ['scss/**/*.scss'],
                tasks: ['sass']
            },

            livereload: {
                // Here we watch the files the sass task will compile to.
                // These files are sent to the live reload server after sass compiles to them.
                options: {
                    livereload: true
                },
                files: ['css/**/*'],
            },
        },

    });

    // Load the Grunt Tasks
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // Register the Grunt Tasks
    grunt.registerTask('build', ['sass']);
    grunt.registerTask('default', ['build', 'concat', 'uglify', 'copy', 'watch']);
}