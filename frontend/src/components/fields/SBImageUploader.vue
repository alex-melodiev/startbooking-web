<template>
  <div class="img-uploader">
    <div class="img-uploader__row">
      <div v-if="images && images.length" class="row row--sm">
        <div v-for="(image, index) in images" class="col col-12 col-md-6 col-lg-4 row__col row__col--sm" :key="index">
          <img class="card-img" :src="image" alt="" />
        </div>
      </div>
    </div>
    <div @drop.prevent="addFile"
         @dragover.prevent="onDrag(true)"
         @dragleave.prevent="onDrag(false)"
         @drop="onDrag(false)"
         @keypress.enter="triggerFile"
         @keypress.space="triggerFile"
         class="img-uploader__row"
         :class="[isOver ? 'img-uploader__row--is-over' : null]"
         tabindex="0"
    >
      <div class="row row--sm">
        <div class="col col-12 col-md-6 col-lg-4">
          <label :for="'file-' + name" class="card card--add" type="button" role="button">
            <SvgIcon className="icon icon--add-circle" name="add-circle" />
          </label>
        </div>
      </div>
    </div>

    <input @input="input" :id="'file-' + name" class="img-uploader__file" type="file" multiple />
  </div>
</template>

<script>
  export default {
    name: "SBImageUploader",
    props: {
      value: {
        type: FileList,
        required: false
      },
      name: {
        type: String,
        required: true
      },
      errors: {
        type: Array,
        required: false
      }
    },
    data() {
      return {
        images: [],
        isOver: false
      }
    },
    methods: {
      triggerFile() {
        document.getElementById('file-' + this.name).click();
      },
      onDrag(isOver) {
        this.$set(this, 'isOver', isOver);
      },
      addFile(event) {
        let droppedFiles = event.dataTransfer.files;
        if(!droppedFiles) return;
        this.saveAndPreview(droppedFiles);
      },
      input(event) {
        const input = event.target;
        this.saveAndPreview(input.files);
      },
      saveAndPreview(files) {
        this.$emit('input', files);
        Array.from(files).forEach((file) => {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.images = [...this.images, e.target.result];
          };
          reader.readAsDataURL(file);
        });
      }
    }
  }
</script>
