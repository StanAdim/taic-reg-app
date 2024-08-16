module.exports = {
    apps: [
      {
        name: 'taic',
        port: '2024',
        exec_mode: 'cluster',
        instances: 'max',
        script: './.output/server/index.mjs'
      }
    ]
  }
  