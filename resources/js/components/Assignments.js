import AssignmentList from "./AssignmentList.js";
import AssignmentCreate from "./AssignmentCreate.js";

export default {
    components: { AssignmentList, AssignmentCreate },

    // :assignment is when providing processed data, without : it will provide value as string like the 'title' prop
    // v-on:add / @add is the parent custom method from this file and helps listen for custom events (add() & $emit syntax) in the child file
    template: `
        <section class="space-y-6">
            <assignment-list :assignments="filters.inProgress" title="In Progress"></assignment-list>
            <assignment-list :assignments="filters.completed" title="Completed"></assignment-list>

            <assignment-create @add="add"></assignment-create>
        </section>
    `,

    data() {
        return {
            // checkbox list
            assignments: [
                {name: 'Finish Vue Lessons', complete: false, id: 1, tag: 'tag 1'},
                {name: 'Finish Advanced PHP Lessons', complete: false, id: 2, tag: 'tag 2'},
                {name: 'Explore Advance MySQL Optimisation', complete: false, id: 3, tag: 'tag 3'},
                {name: 'Try to do more advanced coding task', complete: false, id: 4, tag: 'tag 1'},
            ],
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