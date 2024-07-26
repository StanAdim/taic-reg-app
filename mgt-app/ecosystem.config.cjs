module.exports = {
    apps: [
        {
            name: 'events-stage',
            port: '2224',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
