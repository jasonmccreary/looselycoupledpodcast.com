module.exports = {
  theme: {
  },
  variants: {
    width: ['responsive', 'focus'],
  },
  plugins: [
    function({ addUtilities }) {
      const newUtilities = {
        '.transition-fast': {
          transition: 'all .2s ease-out',
        },
        '.transition': {
          transition: 'all .5s ease-out',
        },
      }

      addUtilities(newUtilities)
    }
  ]
}
