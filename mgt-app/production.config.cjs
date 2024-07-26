module.exports = {
    apps: [
        {
            name: 'events-app',
            port: '2370',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}

