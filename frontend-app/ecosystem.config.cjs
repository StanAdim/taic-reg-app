module.exports = {
    apps: [
        {
            name: 'ems-app-live',
            port: '2007',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
