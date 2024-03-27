/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
  theme: {
    extend: {
        colors: ({ colors }) => ({
            primary: colors.blue,
            secondary: colors.lime,
            accent: colors.pink,
            success: colors.lime,
            danger: colors.red,
            warning: colors.yellow,
            info: colors.blue,
            gray: colors.zinc,
            white: colors.white,
            black: colors.black,
            transparent: colors.transparent,
      }),
      fontFamily: {
        sans: ['Geist', 'Inter', ...defaultTheme.fontFamily.sans],
        mono : ['GeistMono', 'fira-code', ...defaultTheme.fontFamily.mono],
      },
        keyframes: {
            loop: {
                to: {
                    "offset-distance": "100%",
                },
            },
        },
    },
  },
  plugins: [],
}

