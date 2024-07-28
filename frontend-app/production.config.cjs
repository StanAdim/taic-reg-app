module.exports = {
    apps: [
        {
            name: 'events-app',
            port: '6040',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
