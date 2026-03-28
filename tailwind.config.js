/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          50: '#E6F0FA',
          100: '#CCE1F5',
          200: '#99C3EB',
          300: '#66A5E1',
          400: '#3387D7',
          500: '#0A2B5E', // Bleu-nuit principal
          600: '#08244B',
          700: '#061D38',
          800: '#041626',
          900: '#020F13',
        },
        orange: {
          50: '#FFF2E8',
          100: '#FFE5D1',
          200: '#FFCBA3',
          300: '#FFB175',
          400: '#FF9747',
          500: '#FF6B35', // Orange principal
          600: '#E55C2A',
          700: '#CC4D20',
          800: '#B23E15',
          900: '#992F0B',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
    },
  },
  plugins: [],
}