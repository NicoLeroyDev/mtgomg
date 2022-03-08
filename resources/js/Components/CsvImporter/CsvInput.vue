<template>
  <label class="text-reader">
    Read File
    <input type="file" @change="checkFileExtension" />
  </label>
</template>

<script>
export default {
  methods: {
    checkFileExtension(e) {
      const files = e.target.files || e.dataTransfer.files;
      const acceptedFileTypes = ['text/csv'];

      if (files.length && acceptedFileTypes.includes(files[0].type)) {
        this.readFile(e);
      } else {
        // Error logic
      }
    },

    readFile(evt) {
      const scope = this;
      const promiseVar = new Promise(async (resolve, reject) => {
        try {
          const reader = new FileReader();
          const file = evt.target.files[0];
          reader.readAsText(file, 'UTF-8');
          reader.onload = (e) => {
            scope.fileinput = e.target.result;
            resolve('complete');
          };
        } catch (error) {
          console.error(error);
          reject('There must be an error');
        }
      });
      // let updateds = await Promise.all(promiseVar);
      promiseVar.then((data) => {
        scope.afterRead();
      });
    },

    afterRead() {
      const result = [];
      const lines = this.fileinput.split('\n');

      // CSV headers are mandatory
      const headers = lines[0].split(',');

      lines.forEach((line) => {
        if (line) {
          const obj = {};
          const currentLine = line.split(',');

          headers.forEach((header, index) => {
            obj[index] = currentLine[index];
          });

          result.push(obj);
        }
      });

      console.log(result);
    },
  },

  data() {
    return {};
  },
};
</script>
