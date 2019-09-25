<template>
    <section class="feedback-form">
        <form
            v-if="isActive"
            v-closable="{
              exclude: ['formToggle'],
              handler: 'onClose'
            }"
            class="form mb-3"
            role="form"
            @submit.prevent="onSubmit"
        >
            <div class="form-group">
                <label
                    class="form-label"
                    for="feedback-name"
                >Name:*</label>
                <input
                    class="form-control"
                    v-model="nameField"
                    id="feedback-name"
                    type="text"
                />
            </div>
            <div class="form-group">
                <label
                    class="form-label"
                    for="feedback-email"
                >Email:</label>
                <input
                    class="form-control"
                    v-model="emailField"
                    id="feedback-email"
                    type="email"
                />
            </div>
            <div class="form-group">
                <label
                    class="form-label"
                    for="feedback-body"
                >Comment:*</label>
                <textarea
                    class="form-control"
                    resize="false"
                    id="feedback-body"
                    type="text"
                    v-model="body"
                />
            </div>
            <p v-if="success" class="text-success text-center">
                Your feedback<br />has been submitted.
            </p>
            <p v-if="errors" class="text-danger text-center">
              {{ errors }}
            </p>
            <button
                :disabled="!isValid"
                class="form-control btn btn-primary"
                type="submit"
            >
                <div
                    v-if="isLoading"
                    class="spinner-border spinner-border-sm"
                    role="status"
                >
                    <span class="sr-only">Loading...</span>
                </div>
                <div v-else>
                    Submit
                </div>
            </button>
        </form>
        <div class="text-right">
            <button
                ref="formToggle"
                class="feedback-btn btn btn-primary"
                @click="toggleForm"
            >
                <i class="fa fa-question" />
            </button>
        </div>
    </section>
</template>

<style lang="scss">
.feedback-form {
    position: fixed;
    z-index: 100;
    bottom: 1em;
    right: 1em;

    .form {
        max-width: 16em;
        padding: 1em;
        background: white;
        border-radius: 5px;
        border: 1px solid darkgray;
    }

    .feedback-btn {
        font-size: 1.5em;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        color: white;
    }
}
</style>

<script>
import axios from 'axios';

// Closable Directive courtesy of
// https://tahazsh.com/detect-outside-click-in-vue

// This variable will hold the reference to
// document's click handler
let handleOutsideClick;

const Closable = {
    bind(el, binding, vnode) {
        // Here's the click/touchstart handler
        // (it is registered below)
        handleOutsideClick = (e) => {
            e.stopPropagation();
            // Get the handler method name and the exclude array
            // from the object used in v-closable
            const { handler, exclude } = binding.value;

            // This variable indicates if the clicked element is excluded
            let clickedOnExcludedEl = false;
            exclude.forEach((refName) => {
                // We only run this code if we haven't detected
                // any excluded element yet
                if (!clickedOnExcludedEl) {
                    // Get the element using the reference name
                    const excludedEl = vnode.context.$refs[refName];
                    // See if this excluded element
                    // is the same element the user just clicked on
                    clickedOnExcludedEl = excludedEl.contains(e.target);
                }
            });

            // We check to see if the clicked element is not
            // the dialog element and not excluded
            if (!el.contains(e.target) && !clickedOnExcludedEl) {
                // If the clicked element is outside the dialog
                // and not the button, then call the outside-click handler
                // from the same component this directive is used in
                vnode.context[handler]();
            }
        };
        // Register click/touchstart event listeners on the whole page
        document.addEventListener('click', handleOutsideClick);
        document.addEventListener('touchstart', handleOutsideClick);
    },

    unbind() {
        // If the element that has v-closable is removed, then
        // unbind click/touchstart listeners from the whole page
        document.removeEventListener('click', handleOutsideClick);
        document.removeEventListener('touchstart', handleOutsideClick);
    },
};

export default {
    props: ['name', 'email'],

    data() {
        return {
            emailField: this.email,
            nameField: this.name,
            body: null,
            isActive: false,
            isLoading: false,
            errors: null,
            success: false,
        };
    },

    directives: {
        Closable,
    },

    computed: {
        isValid() {
            if (this.isLoading) {
                return false;
            }

            if (!this.name) {
                return false;
            }

            if (!this.body) {
                return false;
            }

            return true;
        },
    },

    methods: {
        toggleForm() {
            this.isActive = !this.isActive;
        },

        onClose() {
            this.isActive = false;
        },

        async onSubmit() {
            try {
                this.errors = null;
                this.success = false;
                this.isLoading = true,

                await axios.post(`/feedback`, {
                    name: this.nameField,
                    email: this.emailField,
                    body: this.body,
                });

                this.isLoading = false;
                this.success = true;

                this.reset();
            } catch (error) {
                this.isLoading = false;
                this.errors = error.message;
            }
        },

        reset() {
            this.body = null;
        },
    },

    mounted() {
        this.reset();
    },

    watch: {
        isActive(value) {
            if (value) {
                return;
            }

            // Reset the state of the form.
            this.success = false;
            this.errors = null;
        },
    },
};
</script>
