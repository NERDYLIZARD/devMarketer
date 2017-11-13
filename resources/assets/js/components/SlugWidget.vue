<style scoped>
  .slug-widget {
    display: flex;
    justify-content: flex-start;
    align-items: center;
  }
  .wrapper {
    margin-left: 8px;
  }
  .slug {
    background-color: #fdfd96;
    padding: 3px 5px
  }
  .input {
    width: auto;
  }
  .url-wrapper {
    display: flex;
    align-items: center;
    height: 28px;
  }
</style>

<template>
  <div class="slug-widget">
    <div class="icon-wrapper wrapper">
      <i class="fa fa-link"></i>
    </div>
    <div class="url-wrapper wrapper">
      <span class="root-url">{{url}}</span
      ><span class="subdirectory-url">/{{subdirectory}}/</span
    ><span class="slug" v-show="slug && !isEditing">{{slug}}</span
    ><input type="text" name="slug" class="input is-small" v-show="isEditing" v-model="customSlug"/>
    </div>

    <div class="button-wrapper wrapper">
      <button class="save-slug-button button is-small" v-show="!isEditing" @click.prevent="editSlug">Edit</button>
      <button class="save-slug-button button is-small" v-show="isEditing" @click.prevent="saveSlug">Save</button>
      <button class="save-slug-button button is-small" v-show="isEditing" @click.prevent="resetEditing">Reset</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      url: {
        type: String,
        require: true
      },
      subdirectory: {
        type: String,
        require: true
      },
      title: {
        type: String,
        require: true
      },
    },
    data() {
      return {
        slug: this.setSlug(this.title),
        customSlug: '',
        isEditing: false,
        wasEdited: false,
        api_token: this.$root.api_token
      }
    },
    methods: {
      setSlug(title) {
        // for the first call from vue
        if (!title || !this.api_token)
          return

        // get unique slug
        axios.get('/api/posts/unique', {
          params: {
            slug: Slug(title),
            api_token: this.api_token
          }})
          .then(response => {
            this.slug = response.data
          })
          .catch(error => {
            console.log(error)
          })
      },
      editSlug() {
        this.isEditing = true
        this.customSlug = this.slug
        this.$emit('edit', this.slug)
      },
      saveSlug() {
        if (this.customSlug !== this.slug) {
          this.wasEdited = true
          this.setSlug(this.customSlug)
        }
        this.isEditing = false
        this.$emit('save', this.slug)
      },
      resetEditing() {
        this.isEditing = false
        this.wasEdited = false
        this.setSlug(this.title)
        this.$emit('reset', this.slug)
      },

    },
    watch: {
      title: _.debounce(function(title) {
        if (!this.wasEdited)
          this.setSlug(title)
      }, 500),
      slug: function() {
        this.$emit('change', this.slug)
      }
    }
  }
</script>
