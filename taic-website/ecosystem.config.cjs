module.exports = {
    apps: [
      {
        name: 'taic-website',
        port: '2024',
        exec_mode: 'cluster',
        instances: 'max',
        script: './.output/server/index.mjs'
      }
    ]
  }
  