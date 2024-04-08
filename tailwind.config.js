const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: ["selector", '[data-theme="dark"]'],
    //   darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            }, animation: {
                'bounce-1': 'bounce 1s infinite',
                'bounce-2': 'bounce 1s infinite 0.2s',
                'bounce-3': 'bounce 1s infinite 0.4s',
            }
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("daisyui"),
    ],

    daisyui: {
        themes: ["winter", "dark"], // true: all themes | false: only light + dark | array: specific themes like this ["light", "dark", "cupcake"]
        darkTheme: "dark", // name of one of the included themes for dark mode
        base: true, // applies background color and foreground color for root element by default
        styled: true, // include daisyUI colors and design decisions for all components
        utils: true, // adds responsive and modifier utility classes
        rtl: false, // rotate style direction from left-to-right to right-to-left. You also need to add dir="rtl" to your html tag and install `tailwindcss-flip` plugin for Tailwind CSS.
        prefix: "", // prefix for daisyUI classnames (components, modifiers and responsive class names. Not colors)
        logs: true, // Shows info about daisyUI version and used config in the console when building your CSS
    },
};
