// JAVASCRIPT MODULE FILE
export default {
    template: `
        <div class="h-full grid place-items-center">
            <button 
                :class="{
                    'border rounded px-5 py-2 disabled:cursor-not-allowed': true,
                    'bg-blue-600 hover:bg-blue-700': type == 'primary',
                    'bg-green-200 hover:bg-green-400': type == 'secondary',
                    'bg-gray-200 hover:bg-gray-400': type == 'muted',
                    'is-loading': processing,
                }"
                :disabled="processing"
            >
                <slot />
            </button>
        </div>
    `,

    props: {
        // type, processing is a custom prop name
        type: {
            type: String,
            default: 'primary'
        },

        // vue will look for 'processing' variable in data() or in props
        processing: {
            type: Boolean,
            default: false
        }
    },
}