export default {
    template: `
        <div class="flex justify-center items-center">
            <button :class="active ? 'text-red' : 'text-green'" @click="toggle">Click Me</button>
        </div>
    `,

    data () {
        return {
            // click me button
            active: false,
        };
    },

    methods: {
        toggle () {
            // negate/opposite of that value when triggered
            this.active = ! this.active;
        },
    },
}