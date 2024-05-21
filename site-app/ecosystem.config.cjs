module.exports = {
    apps: [
      {
        name: 'taic-site',
        port: '2228',
        exec_mode: 'cluster',
        instances: 'max',
        script: './.output/server/index.mjs'
      }
    ]
  }
  