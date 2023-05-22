export default {
    template:`
        <div class="flex gap-2">
            <button 
                @click="$emit('change', tag)"
                v-for="tag in tags" 
                class="border rounded px-1 py-px text-xs"
                :class="{
                    'border-blue-500 text-blue-500': tag === currentTag
                }"
            >{{ tag }}</button>
        </div>
    `,
    
    props: {
        initialTags: Array,
        currentTag: String,
    },

    computed: {
        tags() {
            // array mapping from assignments array
            // to get only the tag value
            // new Set() is for grouping duplicates
            // ... (destructure) is to array merge 'all' with Set()
            return ['all', ...new Set(this.initialTags)];
        },
    },
}