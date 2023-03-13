/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
  daisyui: {
    themes: [
      {
        mytheme: {
          primary: "#2A39C1",

          secondary: "#570DF8",

          accent: "#1FB2A5",

          base: "#FAFAFA",

          "base-100": "#2A303C",

          neutral: "#3D4451",

          info: "#3ABFF8",

          success: "#67E884",

          warning: "#FF9900",

          error: "#DB3434",
        },
      },
      "light",
    ],
  },
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
};
