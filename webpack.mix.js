const mix = require("laravel-mix");
const tailwindcss = require("tailwindcss");

mix.disableSuccessNotifications();
mix.options({
  terser: {
    extractComments: false,
  },
});

mix.setPublicPath("packages/core/dist");
mix.setResourceRoot("packages/core/resources");
mix.sourceMaps();
mix.version();

mix
  .postCss("packages/core/resources/css/core.css", "packages/core/dist", [
    tailwindcss("packages/core/tailwind.config.js"),
  ])
  .options({
    processCssUrls: false,
  });
