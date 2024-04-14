import { defineComponent, h } from 'vue'

export const checkIcon = defineComponent({
    render () {
        return h('svg', {
            width: '20',
            height: '20',
            viewBox: '0 0 20 20',
            fill: 'none',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('path', {
                d: 'M16.7071 5.29289C17.0976 5.68342 17.0976 6.31658 16.7071 6.70711L8.70711 14.7071C8.31658 15.0976 7.68342 15.0976 7.29289 14.7071L3.29289 10.7071C2.90237 10.3166 2.90237 9.68342 3.29289 9.29289C3.68342 8.90237 4.31658 8.90237 4.70711 9.29289L8 12.5858L15.2929 5.29289C15.6834 4.90237 16.3166 4.90237 16.7071 5.29289Z',
                fill: 'currentColor'
            })
        ])
    }
})

export const searchLensIcon = defineComponent({
    render () {
        return h('svg', {
            width: '24',
            height: '24',
            viewBox: '0 0 24 24',
            fill: 'none',
            xmlns: 'http://www.w3.org/2000/svg'
        }, [
            h('circle', {
                cx: '13',
                cy: '11',
                r: '6',
                stroke: 'currentColor',
                'stroke-width': '2',
                'stroke-linecap': 'round'
            }),
            h('path', {
                d: 'M8 16C7.87368 16.1263 5.94737 18.0526 5 19',
                stroke: 'currentColor',
                'stroke-width': '2',
                'stroke-linecap': 'round'
            })
        ])
    }
})
