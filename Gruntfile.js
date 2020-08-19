
module.exports = function( grunt ) {
    grunt.initConfig( {
        pkg: grunt.file.readJSON( "package.json" ),

        phpcs: {
            plugin: {
                src: [ "./*.php", "./includes/*.php", "./tests/*.php" ]
            },
            options: {
                bin: "vendor/bin/phpcs --extensions=php --ignore=\"*/vendor/*,*/node_modules/*\"",
                standard: "phpcs.ruleset.xml"
            }
        },

        jscs: {
            scripts: {
                src: [ "Gruntfile.js", "src/js/*.js" ],
                options: {
                    preset: "jquery",
                    requireCamelCaseOrUpperCaseIdentifiers: false, // We rely on name_name too much to change them all.
                    maximumLineLength: 250
                }
            }
        },

        jshint: {
            grunt_script: {
                src: [ "Gruntfile.js" ],
                options: {
                    curly: true,
                    eqeqeq: true,
                    noarg: true,
                    quotmark: "double",
                    undef: true,
                    unused: false,
                    node: true     // Define globals available when running in Node.
                }
            }
        },
        sass: {
            // Begin Sass Plugin
            dist: {
              options: {
                // sourcemap: 'none',
                loadPath: 'node_modules/bootstrap-4-grid/scss'
              },
              files: [
                {
                  expand: true,
                  cwd: 'sass',
                  src: ['**/*.scss'],
                  dest: 'css',
                  ext: '.css',
                },
              ],
            },
          },
          postcss: {
            // Begin Post CSS Plugin
            options: {
              map: false,
              processors: [
                require('autoprefixer')({
                  browsers: ['last 2 versions'],
                }),
              ],
            },
            dist: {
              src: 'css/style.css',
            },
          },
          cssmin: {
            // Begin CSS Minify Plugin
            target: {
              files: [
                {
                  expand: true,
                  cwd: 'css',
                  src: ['*.css', '!*.min.css'],
                  dest: 'css',
                  ext: '.min.css',
                },
              ],
            },
          },
          watch: {
            // Compile everything into one task with Watch Plugin
            css: {
              files: '**/*.scss',
              tasks: ['sass', 'postcss', 'cssmin'],
            },
          },
    } );

	grunt.loadNpmTasks( "grunt-jscs" );
	grunt.loadNpmTasks( "grunt-contrib-jshint" );
    grunt.loadNpmTasks( "grunt-phpcs" );

    grunt.loadNpmTasks('grunt-contrib-sass')
    grunt.loadNpmTasks('grunt-postcss')
    grunt.loadNpmTasks('grunt-contrib-cssmin')
    grunt.loadNpmTasks('grunt-contrib-uglify')
    grunt.loadNpmTasks('grunt-contrib-watch')

    // Default task(s).
    grunt.registerTask( "default", [ "phpcs", "jscs", "jshint", "sass", "watch" ] );
};
