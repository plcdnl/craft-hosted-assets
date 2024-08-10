Craft.AssetIndex.prototype.init = new Proxy(Craft.AssetIndex.prototype.init, {
  apply: function (target, thisArg, argArray) {
    Reflect.apply(target, thisArg, argArray);

    thisArg.getButtonContainer().addClass("flex");
  },
});

Craft.AssetIndex.prototype.createUploadInputs = new Proxy(
  Craft.AssetIndex.prototype.createUploadInputs,
  {
    apply: function (target, thisArg, argArray) {
      Reflect.apply(target, thisArg, argArray);

      thisArg.$createButton?.remove();

      if (
        thisArg.$source.data("volume-handle") ===
        Craft.HostedVideos.volumeHandle
      ) {
        if (Craft.HostedVideos.hideUploadButton) {
          thisArg.$uploadButton?.remove();
        }

        thisArg.$createButton = $("<button/>", {
          type: "button",
          class: "btn submit",
          "data-icon": "plus",
          text: Craft.t("_hosted-videos", "New video"),
        });

        thisArg.getButtonContainer().prepend(thisArg.$createButton);

        thisArg.$createButton.on("click", () => {
          const currentFolder =
            thisArg.sourcePath[thisArg.sourcePath.length - 1];

          const data = {
            folderId: currentFolder.folderId,
          };

          thisArg.setIndexBusy();

          Craft.sendActionRequest(
            "POST",
            "_hosted-videos/assets/create-hosted-video",
            { data },
          )
            .then((response) => {
              thisArg.setIndexAvailable();
              Craft.cp.displaySuccess(
                Craft.t("_hosted-videos", "Video created."),
              );
              thisArg.updateElements();
            })
            .catch(({ response }) => {
              thisArg.setIndexAvailable();
              Craft.cp.displayError(response.data.message);
            });
        });
      }
    },
  },
);
