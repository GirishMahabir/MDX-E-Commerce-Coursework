const input = document.getElementById("image")
const output = document.querySelector("output")

let imagesArray = []

input.addEventListener("change", () => {
    /*
        This event listener will add the image to the imagesArray
        and call the displayImages function to display the images.
        It will also reset the input value to empty string.
    */
    const file = input.files
    imagesArray.push(file[0])
    displayImages()
})

function displayImages() {
    /*
    *   This function will display the images in the output element
    *   and add an event listener to each image to delete it when clicked.
    */
    output.innerHTML = ""
    imagesArray.forEach((image, index) => {
        const img = document.createElement("img")
        img.src = URL.createObjectURL(image)
        img.width = 200
        img.height = 200
        img.style.margin = "10px"
        img.style.border = "1px solid black"
        img.style.borderRadius = "10px"
        img.style.objectFit = "cover"
        img.addEventListener("click", () => {
            deleteImage(index)
            input.value = ""
        })
        output.appendChild(img)
    })
}

function deleteImage(index) {
    /*
    Function to delete an image from the imagesArray.
    */
    imagesArray.splice(index, 1)
    displayImages()
}


