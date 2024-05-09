<template>
    <div @click="openFileInput" class="relative w-full h-full overflow-hidden cursor-pointer">
      <input ref="fileInput" type="file" @change="previewImage" accept="image/*" class="hidden">
      <div v-if="imageUrl" class="w-full h-full">
        <img :src="imageUrl" alt="Preview" class="object-cover w-full h-full rounded-lg">
      </div>
      <div v-else>
        <p>Clique aqui para selecionar uma imagem</p>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        imageUrl: null
      };
    },
    methods: {
      openFileInput() {
        this.$refs.fileInput.click();
      },
      previewImage(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = (e) => {
            this.imageUrl = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      }
    }
  };
  </script>
ß
