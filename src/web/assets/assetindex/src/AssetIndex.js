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
          if (thisArg.$createButton.hasClass("loading")) {
            return;
          }

          const currentFolder =
            thisArg.sourcePath[thisArg.sourcePath.length - 1];

          const data = {
            folderId: currentFolder.folderId,
          };

          const inModal = thisArg.$createButton.closest(".modal").length > 0;

          if (inModal) {
            thisArg.setIndexBusy();
          } else {
            thisArg.$createButton.addClass("loading");
          }

          Craft.sendActionRequest(
            "POST",
            "_hosted-videos/assets/create-hosted-video",
            { data },
          )
            .then((response) => {
              if (inModal) {
                thisArg.setIndexAvailable();
                thisArg.updateElements();
                thisArg.selectElementAfterUpdate(response.data.asset.id);
              } else {
                Craft.redirectTo(response.data.cpEditUrl);
              }
            })
            .catch(({ response }) => {
              Craft.cp.displayError(response.data.message);
            })
            .finally(() => {
              if (!inModal) {
                thisArg.$createButton.removeClass("loading");
              }
            });
        });
      }
    },
  },
);
