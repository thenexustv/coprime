'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    // require('load-grunt-tasks')(grunt);
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	function get_banner() {
		return '/*! <%= pkg.name %> <%= pkg.version %> <=% grunt.template.today("yyyy-mm-dd") %> */\n';
	}

	// handles the wordpress theme file
	grunt.task.registerTask('wpt', 'A task that sets the version in the WordPress style.css file', function(){

		var pkg = grunt.file.readJSON('package.json');

		var from_filename = 'style.template.css';
		var to_filename = 'style.css';
		var contents = grunt.file.read(from_filename);
		var obj = {version: pkg.version};

		contents = grunt.template.process(contents, {data: obj});

		grunt.log.oklns("WordPress style.css updated sucessfully!");
		grunt.file.write(to_filename, contents);

	});

    grunt.initConfig({

    	// import metadata from the package
		pkg: grunt.file.readJSON('package.json'),

        // watch for changes and trigger compass, jshint, uglify and livereload
        watch: {
            compass: {
                files: ['resources/css/source/**/*.{scss,sass}'],
                tasks: ['compass:dev']
            },
            js: {
                files: 'resources/js/source/**/*.js',
                tasks: ['uglify:dev']
            }
        },

        // compass and scss
        compass: {
            dev: {
                options: {
                    config: 'config.rb',
                    force: true,
                    outputStyle: 'expanded',
                }
            },
            production: {
                options: {
                    config: 'config.rb',
                    force: true,
                    outputStyle: 'compressed',
                }
            }
        },



        // uglify to concat, minify, and make source maps
        uglify: {
            dev: {
            	options: {
            		banner: get_banner(),
            		compress: false,
            		beautify: true,
            		mangle: false
            	},
                files: {
                    'resources/js/build/main.js': ['resources/js/source/main.js']
                }
            },
            production: {
            	options: {
            		banner: get_banner(),
            		compress: true,
            	},
                files: {
                    'resources/js/build/main.js': ['resources/js/source/main.js']
                }
            }
        },

        // deploy via rsync
        rsync: {
            options: {
                src: "./",
                args: ["--verbose", "-n"],
                exclude: ['.git*', 'node_modules', '.sass-cache', 'Gruntfile.js', 'package.json', '.DS_Store', 'config.rb', '.jshintrc'],
                recursive: true,
                syncDestIgnoreExcl: true
            },
            production: {
                options: {
                    dest: "/srv/www/thenexus.tv/public_html/wp-content/themes/coprime/",
                    host: "ryan@thenexus.tv"
                }
            }
        }

    });

	
    grunt.registerTask('deploy', ['compass:production', 'uglify:production', 'wpt', 'rsync:production']);

    grunt.registerTask('default', ['compass:dev', 'uglify:dev', 'watch']);

};
