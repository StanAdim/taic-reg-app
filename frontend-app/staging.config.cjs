module.exports = {
    apps: [
        {
            name: 'test-ems',
            port: '2021',
            exec_mode: 'cluster',
            instances: 'max',
            script: './.output/server/index.mjs'
        }
    ]
}
