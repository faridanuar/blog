// JAVASCRIPT MODULE FILE
import AppButton from "./AppButton.js";
import Assignments from "./Assignments.js";
import ClickMeButton from "./ClickMeButton.js";
import Panel from "./Panel.js";

export default {
    components: {
        Panel,
        Assignments,
        'click-me-button': ClickMeButton,
        'app-button': AppButton
    },

    // this will take priority, it will orverride the components property and only display what's inside this template property
    // template: `
    //     <assignments></assignments>
    //     <click-me-button></click-me-button>
    //     <app-button :processing="false">Submit</app-button>
    // `,
}