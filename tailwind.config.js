module.exports = {
    content: [
        "./resources/**/*.blade.php", "./resources/**/*.js", "./resources/**/*.vue",
    //   './resources/**/*.{html,js,php}', // Sesuaikan dengan struktur proyek kamu
    ],
    theme: {
      extend: {
        colors: {
          primary: {
            50: '#f0f6ff',
            100: '#e0ecff',
            200: '#c0daff',
            300: '#91bfff',
            400: '#609cff',
            500: '#3b7dff',
            600: '#1859E7',  // Our main brand color
            700: '#1145cc',
            800: '#1239a7',
            900: '#163584',
          },
        },
        spacing: {
          '128': '32rem',
        },
        maxWidth: {
          '8xl': '88rem',
        },
        boxShadow: {
          'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
        },
      },
    },
    plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/aspect-ratio'),
      require('@tailwindcss/typography'),
    ],
  };
  