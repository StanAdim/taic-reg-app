module.exports = {
    apps: [
        {
            name: 'taic-reg-app',
            port: '2224',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
