module.exports = {
    apps: [
        {
            name: 'event-app',
            port: '2370',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
