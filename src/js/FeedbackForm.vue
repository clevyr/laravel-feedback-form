<template>
    <section class="feedback-form">
        <form
            v-if="isActive"
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
    position: absolute;
    bottom: 1em;
    right: 1em;

    .form {
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

        async onSubmit() {
            try {
                this.errors = null;
                this.success = false;
                this.isLoading = true,

                await axios.post(`/feedback`, {
                    name: this.name,
                    email: this.email,
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
        }
    },

    mounted() {
        this.reset();
    },
};
</script>
