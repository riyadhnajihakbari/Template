/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'pos-primary': '#FF6B35',      // Orange (Main Brand Color)
        'pos-primary-hover': '#E55A2B', // Orange Hover
        'pos-secondary': '#10b981',     // Green (Success)
        'pos-warning': '#f59e0b',       // Amber (Warning)
        'pos-danger': '#ef4444',        // Red (Danger)
        'pos-info': '#3b82f6',          // Blue (Info)
        'pos-dark': '#1a1a1a',          // Dark Background
        'pos-card': '#2d2d2d',          // Dark Card
      },
      backgroundColor: {
        'dark': '#1a1a1a',
        'dark-card': '#2d2d2d',
        'dark-hover': '#3d3d3d',
      },
      borderColor: {
        'dark': '#404040',
      },
      boxShadow: {
        'primary': '0 4px 12px rgba(255, 107, 53, 0.4)',
        'primary-lg': '0 8px 25px rgba(255, 107, 53, 0.5)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}