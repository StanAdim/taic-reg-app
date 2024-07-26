module.exports = {
    apps: [
        {
            name: 'events-app',
            port: '4404',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}

