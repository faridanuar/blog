import AssignmentList from "./AssignmentList.js";
import AssignmentCreate from "./AssignmentCreate.js";

export default {
    components: { AssignmentList, AssignmentCreate },

    // :assignment is when providing processed data, without : it will provide value as string like the 'title' prop
    // v-on:add / @add is the parent custom method from this file and helps listen for custom events (add() & $emit syntax) in the child file
    template: `
        <section class="flex gap-8">
            <assignment-list :assignments="filters.inProgress" title="In Progress">
                <assignment-create @add="add"></assignment-create>
            </assignment-list>
            
            <assignment-list
                v-if="showCompleted"
                :assignments="filters.completed" 
                title="Completed"
                can-toggle
                @toggle="showCompleted = !showCompleted"
            ></assignment-list>
        </section>
    `,

    data() {
        return {
            // list of data variable
            assignments: [],
            showCompleted: true,
        }
    },

    computed: {
        filters() {
            return {
                inProgress: this.assignments.filter(assignment => ! assignment.complete),
                completed: this.assignments.filter(assignment => assignment.complete),
            }
        }
    },

    // use instance created() to do ajax request to call data list from API
    created() {
        // fetch is on standby ready to pull data from the url
        fetch('http://localhost:3001/assignments')
            // request for json format of the data
            .then(response => response.json())
            // execute then get the list of data
            .then(assignments => {
                this.assignments = assignments;
            });
    },

    methods: {
        // (name) is from the 2nd argument in this.$emit('add', this.newAssignment);
        add(name) {
            this.assignments.push({
                name: name,
                complete: false,
                id: this.assignments.length + 1,
            });
        }
    }
}