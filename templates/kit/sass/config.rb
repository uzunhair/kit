Encoding.default_external = "utf-8"
# include libs for project
require 'compass'
require 'autoprefixer-rails'
#require 'csso'
#require 'zen-grids'

# PATH your project
relative_assets = true                  # because we're not working from the root
css_dir = "../css"                      # where the CSS will saved
sass_dir = ""                           # where our .scss files are
images_dir = "../img"                   # the folder with your images
javascripts_dir = "../js"               # the folder with your javasript

# You can select your preferred output style here (can be overridden via the command line):
output_style = :compressed # :nested, :expanded, :compact, or :compressed. After dev :compressed

# To disable debugging comments that display the original location of your selectors. Uncomment:
line_comments = false

# Obviously
preferred_syntax = :scss

#source map
sourcemap = true

# event task for auto-prefixer and notify saved your styles #Csso.optimize
on_stylesheet_saved do |file|
  css = File.read(file)
  map = file + '.map'

  if File.exists? map
    result = AutoprefixerRails.process(css,
      from: file,
      to:   file,
      map:  { prev: File.read(map), inline: false },
      browsers: ['ie > 8', 'last 3 versions', '> 2%'])
    File.open(file, 'w') { |io| io << result.css }
    File.open(map,  'w') { |io| io << result.map }
  else
    File.open(file, 'w') { |io| io << AutoprefixerRails.process(css, browsers: ['ie > 8', 'last 3 versions', '> 2%']) }
  end
end

