import pymongo
import base64

product_list = {
    'P001': {
        'name': 'Asus ROG Strix G15',
        'price': '$1499.99',
        'description': 'The Asus ROG Strix G15 is a gaming laptop that is powered by the AMD Ryzen 7 5800H processor and the NVIDIA GeForce RTX 3060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop1.jpg',
        'quantity': '10'
    },
    'P002': {
        'name': 'Asus Zephyrus G14',
        'price': '$1499.99',
        'description': 'The Asus Zephyrus G14 is a gaming laptop that is powered by the AMD Ryzen 9 5900HS processor and the NVIDIA GeForce RTX 3060 graphics card. It has a 14-inch 1080p 120Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 57Wh battery. It runs Windows 10 Home.',
        'image': './laptop2.jpg',
        'quantity': '10'
    },
    'P003': {
        'name': 'MSI GF65 Thin',
        'price': '$1499.99',
        'description': 'The MSI GF65 Thin is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop3.jpg',
        'quantity': '10'
    },
    'P004': {
        'name': 'MSI Prestige 14',
        'price': '$1499.99',
        'description': 'The MSI Prestige 14 is a laptop that is powered by the Intel Core i7-1165G7 processor and the NVIDIA GeForce MX450 graphics card. It has a 14-inch 1080p 120Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop4.jpg',
        'quantity': '10'
    },
    'P005': {
        'name': 'MSI Modern 14',
        'price': '$1499.99',
        'description': 'The MSI Modern 14 is a laptop that is powered by the Intel Core i7-1165G7 processor and the NVIDIA GeForce MX450 graphics card. It has a 14-inch 1080p 120Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop5.jpg',
        'quantity': '10'
    },
    'P006': {
        'name': 'MSI Modern 15',
        'price': '$2499.99',
        'description': 'The MSI Modern 15 is a laptop that is powered by the Intel Core i7-1165G7 processor and the NVIDIA GeForce MX450 graphics card. It has a 15.6-inch 1080p 120Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop6.jpg',
        'quantity': '10'
    },
    'P007': {
        'name': 'Acer Nitro 5',
        'price': '$899.99',
        'description': 'The Acer Nitro 5 is a gaming laptop that is powered by the AMD Ryzen 5 4600H processor and the NVIDIA GeForce GTX 1650 Ti graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 8GB of RAM, and a 256GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop7.jpg',
        'quantity': '10'
    },
    'P008': {
        'name': 'MSI GF63 Thin',
        'price': '$1499.99',
        'description': 'The MSI GF63 Thin is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop8.jpg',
        'quantity': '10'
    },
    'P009': {
        'name': 'Acer Predator Helios 300',
        'price': '$1000.00',
        'description': 'The Acer Predator Helios 300 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop9.jpg',
        'quantity': '10'
    },
    'P010': {
        'name': 'Acer Predator Triton 300',
        'price': '$999.99',
        'description': 'The Acer Predator Triton 300 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop10.jpg',
        'quantity': '10'
    },
    'P011': {
        'name': 'XPG Gammix S11 Pro',
        'price': '$1399.99',
        'description': 'The XPG Gammix S11 Pro is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop11.jpg',
        'quantity': '10'
    },
    'P012': {
        'name': 'Acer Predator Triton 500',
        'price': '$1699.99',
        'description': 'The Acer Predator Triton 500 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop12.jpg',
        'quantity': '10'
    },
    'P013': {
        'name': 'Lenovo Legion 5',
        'price': '$999.99',
        'description': 'The Lenovo Legion 5 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop13.jpg',
        'quantity': '10'
    },
    'P014': {
        'name': 'Acers Predator Helios 300',
        'price': '$999.99',
        'description': 'The Acer Predator Helios 300 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop14.jpg',
        'quantity': '10'
    },
    'P015': {
        'name': 'Acer Nitro 5',
        'price': '$800.00',
        'description': 'The Acer Nitro 5 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop15.jpg',
        'quantity': '7'
    },
    'P016': {
        'name': 'Asus TUF Gaming A15',
        'price': '$999.99',
        'description': 'The Asus TUF Gaming A15 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop16.jpg',
        'quantity': '10'
    },
    'P017': {
        'name': 'Acer Predator Helios 600',
        'price': '$799.99',
        'description': 'The Acer Predator Helios 600 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop17.jpg',
        'quantity': '10'
    },
    'P018': {
        'name': 'VivoBook S15',
        'price': '$699.99',
        'description': 'The VivoBook S15 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop18.jpg',
        'quantity': '10'
    },
    'P019': {
        'name': 'MSI GT76 Titan',
        'price': '$3000.00',
        'description': 'The MSI GT76 Titan is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop19.jpg',
        'quantity': '10'
    },
    'P020': {
        'name': 'Acer Triton 800',
        'price': '$2000.00',
        'description': 'The Acer Triton 800 is a gaming laptop that is powered by the Intel Core i7-10750H processor and the NVIDIA GeForce RTX 2060 graphics card. It has a 15.6-inch 1080p 144Hz IPS display, 16GB of RAM, and a 512GB SSD. It also has a 720p webcam, Wi-Fi 6, Bluetooth 5.0, and a 3-cell 51Wh battery. It runs Windows 10 Home.',
        'image': './laptop20.jpg',
        'quantity': '10'
    }
}

# Add all theses products to the mongoDB database
# MongoDB Configuration Variables.
MONGODB_USER = "php-cms-user"
MONGODB_PASSWORD = "ZzZBTGVQD3hUnqPT"
MONGODB_DATABASE = "mdxWebDatabase"
MONGODB_URL = "mdx-webdev-ecommerce.5728hfn.mongodb.net/?retryWrites=true&w=majority"

# Connect to MongoDB.
client = pymongo.MongoClient(
    "mongodb+srv://" + MONGODB_USER + ":" + MONGODB_PASSWORD + "@" + MONGODB_URL)
db = client[MONGODB_DATABASE]
products = db["products"]

# Insert all the products into the database.
for product in product_list:

    # The key is the "productId" in the database.
    product_list[product]['productId'] = product

    # convert the image to binary
    binary_data = open(product_list[product]['image'], 'rb').read()

    product_list[product]['image'] = binary_data
    products.insert_one(product_list[product])
