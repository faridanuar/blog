<x-layout>

    <head>
        <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @keyframes spinner {
                to {
                    transform: rotate(360deg);
                }
            }

            .is-loading {
                color: transparent;
            }

            .is-loading:before {
                content: '';
                box-sizing: border-box;
                position: absolute;
                top: 50%;
                left: 50%;
                width: 20px;
                height: 20px;
                margin-top: -10px;
                margin-left: -10px;
                border-radius: 50%;
                border: 2px solid #ccc;
                border-top-color: #000;
                animation: spinner .6s linear infinite;
            }

            .text-red {
                color: red;
            }

            .text-green {
                color: green;
            }
        </style>
    </head>
    <main class="max-w-lg mx-auto mt-10 space-y-6">
        <h4 style="text-align:center"><b>CODING PLAYGROUND</b></h4>

        <div id="app">
            <div class="grid grap-6">
                <x-panel class="mt-5 bg-gray-800 text-white h-full grid place-items-center">
                    <assignments></assignments>

                    <panel>
                        <template v-slot:heading>Dark Panel heading</template>

                        Default Slot Here

                        <template v-slot:footer>Footer here</template>
                    </panel>

                    <panel theme="light">
                        <template v-slot:heading>Light Panel Heading</template>

                        Default Slot Here

                        <template v-slot:footer>Footer here</template>
                    </panel>
                </x-panel>
            </div>

            <x-panel class="mt-5">
                <click-me-button></click-me-button>
            </x-panel>

            <x-panel class="mt-5">
                <div class="h-full grid place-items-center">
                    <!-- this tag <> is from declared vue component -->
                    <app-button :processing="false">Submit</app-button>
                </div>
            </x-panel>
        </div>
    </main>

    <script type="module">
        import App from "./js/components/App.js";

        // get App from import js
        Vue.createApp(App).mount('#app');
    </script>

    {{-- REFERENCE FOR VUE COMPONENTS --}}

    {{-- <x-panel>
        <click-me-button></click-me-button>
    </x-panel>

    <x-panel class="mt-5">
        <progress-list></progress-list>
    </x-panel>

    <x-panel class="mt-5">
        <div class="h-full grid place-items-center">
            <!-- this tag is from declared vue component -->
            <app-button :processing="true">Submit</app-button>
        </div>
    </x-panel> --}}


    {{-- REFERENCE FOR RAW VUE CODE --}}

    {{-- - <div class="flex justify-center items-center">
        <button :class="active ? 'text-red' : 'text-green'" @click="toggle">Click Me</button>
    </div> --}}

    {{-- <section v-show="inProgressAssigments.length" class="h-full grid place-items-center">
        <h2 class="font-bold mb-2">In Progress</h2>

        <ul>
            <li 
                v-for="assignment in inProgressAssigments" 
                :key="assignment.id"
            >
                <label>
                    add @ when trying to echo vue components because laravel got confused
                    @{{ assignment.name }}

                    <input type="checkbox" v-model="assignment.complete">
                </label>
            </li>
        </ul>

        USEFUL FOR DEBUGGING
        <pre>
            @{{ assignments }}
        </pre> 
        
    </section>

    <section v-show="completedAssigments.length" class="h-full grid place-items-center mt-8">
        <h2 class="font-bold mb-2">Completed</h2>

        <ul>
            <li 
                v-for="assignment in completedAssigments" 
                :key="assignment.id"
            >
                <label>
                    @{{ assignment.name }}

                    <input type="checkbox" v-model="assignment.complete">
                </label>
            </li>
        </ul>
    </section> --}}

    {{-- <script>
        //import AppButton from "./js/components/AppButton.js";
        
        // CLEAN STRUCTURE
        // let app = {
        //     data () {
        //         return {
        //             // click me button
        //             active: false,
        //             // checkbox list
        //             assignments: [
        //                 {name: 'Finish Vue Lessons', complete: false, id:1},
        //                 {name: 'Finish Advanced PHP Lessons', complete: false, id:2},
        //                 {name: 'Explore Advance MySQL Optimisation', complete: false, id:3},
        //                 {name: 'Try to do more advanced coding task', complete: false, id:4},
        //             ],
        //         };
        //     },

        //     methods: {
        //         toggle () {
        //             // negate/opposite of that value when triggered
        //             this.active = ! this.active;
        //         },
        //     },

        //     computed: {
        //         inProgressAssigments () {
        //             return this.assignments.filter(assignment => ! assignment.complete);
        //         },

        //         completedAssigments () {
        //             return this.assignments.filter(assignment => assignment.complete);
        //         }
        //     },

        //     // VUE COMPONENT STRUCTURE WITH IMPORT
        //     components: {
        //         'app-button': AppButton
        //     }

        //     // VUE COMPONENT STRUCTURE
        //     // components: {
        //     //     'app-button': {
        //     //         template: `
        //     //             <button class="bg-gray-200 hover:bg-gray-400 border rounded px-5 py-2 disabled:cursor-not-allowed" :disabled="processing">
        //     //                 <slot />
        //     //             </button>
        //     //         `,

        //     //         data() {
        //     //             return {
        //     //                 processing: true,
        //     //             }
        //     //         }
        //     //     },
        //     // }
        // };
        // Vue.createApp(app).mount('#app');

        // DEFAULT STRUCTURE
        // Vue.createApp({
        //     data () {
        //         return {
        //             active: false,
        //         };
        //     },

        //     methods: {
        //         // click me button
        //         toggle () {
        //             // negate/opposite of that value when triggered
        //             this.active = ! this.active;
        //         }
        //     }
        // }).mount('#app');
    </script> --}}
</x-layout>
