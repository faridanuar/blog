export default {
    template:`
        <form @submit.prevent="add" class="flex flex-row justify-center items-center">
            <div class="border border-gray-600 text-black">
                <input v-model="newAssignment" placeholder="New Assignment..." class="p-2" />
                <button type="submit" class="bg-white p-2 border-l">Add</button>
            </div>
        </form>
    `,

    data() {
        return {
            newAssignment: '',
        }
    },

    props: {
        assignments: Array,
    },

    methods: {
        add() {
            // act as a bullhorn notifying the parent component of this file telling there's an action happend in this file
            // and hold the data input (if have any)
            this.$emit('add', this.newAssignment);

            this.newAssignment = '';
        }
    }
}