var gulp     = require( 'gulp' );
var sass     = require( 'gulp-sass' );
var prefixer = require( 'gulp-autoprefixer' );
var pxtorem  = require( 'gulp-pxtorem' );
var cleanCSS = require( 'gulp-clean-css' );

gulp.task( "sass", function() {
  return gulp.src( "assets/sass/main.scss" )
    .pipe( sass().on( "error", sass.logError ) )
    .pipe( prefixer( "last 2 versions" ) )
    .pipe( pxtorem( {
      rootValue:16,
      propList: ['font', 'font-size', 'line-height', 'letter-spacing','padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'margin', 'margin-top', 'margin-right', 'margin-bottom', 'margin-left', 'width', 'height','border','border-radius', 'max-width', 'min-width', 'left', 'top', 'bottom', 'right'],
    } ) )
    .pipe( cleanCSS({compatibility: 'ie8'}) )
    .pipe( gulp.dest( "assets/css" ) )
} );

gulp.task( "watch", function(){
	gulp.watch( "assets/sass/**/*.scss", gulp.series( "sass" ) );
} );