import requests, re, json, random
import unicodedata

domain =  "https://www.chamacomputers.lk"

linksArray = [
    
    
    
    
]

""" 
    { "link": "https://www.chamacomputers.lk/products/graphics%20cards", "cat": "Graphics Cards" },
{ "link": "https://www.chamacomputers.lk/products/graphics%20cards", "cat": "Graphics Cards" },
{ "link": "https://www.chamacomputers.lk/products/processors", "cat": "Processors" }
{ "link": "https://www.chamacomputers.lk/products/thermal%20paste", "cat": "Thermal Paste" },
{ "link": "https://www.chamacomputers.lk/products/motherboards", "cat": "Motherboards" },
    { "link": "https://www.chamacomputers.lk/products/coolers", "cat": "Coolers" },
    { "link": "https://www.chamacomputers.lk/products/memory", "cat": "Memory" },
    { "link": "https://www.chamacomputers.lk/products/ssd", "cat": "SSD" },
    { "link": "https://www.chamacomputers.lk/products/storage", "cat": "Storage" },
    { "link": "https://www.chamacomputers.lk/products/power%20supply", "cat": "Power Supply" },
    { "link": "https://www.chamacomputers.lk/products/pc%20cases", "cat": "PC Cases" },
    { "link": "https://www.chamacomputers.lk/products/monitors", "cat": "Monitors" },

"""

lins = [
    { "link": "https://www.chamacomputers.lk/products/mobiles", "cat": "Mobiles" },
    { "link": "https://www.chamacomputers.lk/products/ups", "cat": "UPS" },
    { "link": "https://www.chamacomputers.lk/products/laptops", "cat": "Laptops" },
    { "link": "https://www.chamacomputers.lk/products/chairs", "cat": "Chairs" },
    { "link": "https://www.chamacomputers.lk/products/tables", "cat": "Tables" },
    { "link": "https://www.chamacomputers.lk/products/headsets", "cat": "Headsets" },
    { "link": "https://www.chamacomputers.lk/products/keyboards", "cat": "Keyboards" },
    { "link": "https://www.chamacomputers.lk/products/mouse", "cat": "Mouse" },
    { "link": "https://www.chamacomputers.lk/products/mouse%20pad", "cat": "Mouse Pad" },
    { "link": "https://www.chamacomputers.lk/products/speakers", "cat": "Speakers" },
    { "link": "https://www.chamacomputers.lk/products/cables", "cat": "Cables" },
    { "link": "https://www.chamacomputers.lk/products/consoles", "cat": "Consoles" },
    { "link": "https://www.chamacomputers.lk/products/apple", "cat": "Apple Products" },
    { "link": "https://www.chamacomputers.lk/products/streaming", "cat": "Streaming Equipment" },
    { "link": "https://www.chamacomputers.lk/products/adapters", "cat": "Adapters" },
    { "link": "https://www.chamacomputers.lk/products/printers", "cat": "Printers" }
]


products = []

def normalize_unicode(text: str) -> str:
    try:
        # Attempt to fix double-encoded Unicode characters
        corrected_text = text.encode("latin1", errors="ignore").decode("utf-8", errors="ignore")
        return unicodedata.normalize("NFKC", corrected_text)
    except UnicodeEncodeError:
        return text  # Return original text if encoding fails

index = 1
for category in lins:
    rawitems = re.sub(r'\n', '', requests.get(category['link']).content.decode('utf-8'))
    with open('main.html', 'w', encoding='utf-8') as file:file.write(rawitems)
    find = re.findall(r'href="(?P<link>\/products\/[A-z]+\/.+?)"', rawitems)
    if (len(find) == 0):
        find = re.findall(r'href="(?P<link>\/products\/[A-z0-9/%.]+?)"><te', rawitems)
    for each in find:
        response = requests.get(domain + each)
        rawdata = re.sub(r'\n', '', response.content.decode('utf-8'))
        description = re.findall(r'<meta name="description" content="(?P<description>.+?)"\/><meta', response.content.decode('utf-8'), re.DOTALL)
        data = re.search(r'price\\":(?P<price>\d+).+?name\\":\\"(?P<name>[^"]+)\\",\\"des.+as="image" href="(?P<image>.+?)".+?whitespace-pre-wrap">(?P<description>.+?)</small>', rawdata)
        if (data and description):
            print('OK: (%s) ' % (str(index).zfill(3)) + data.group('name'))
            products.append({
                "name": normalize_unicode(data.group('name')),
                "price": data.group('price'),
                "image": data.group('image'),
                "description": description[0],
                "category": category["cat"]
            })
            index += 1

with open('content.json', 'w') as content:
    content.write(json.dumps(products, indent=4))

with open('product_insert.sql', 'w', encoding='utf-8') as sqlFile:
    for item in products:
        sqlFile.write("INSERT INTO `products`(`name`, `description`, `price`, `stock`, `image`, `rating`, `category`) VALUES ('%s','%s', %s, %s,'%s', %s, '%s');" % (
            normalize_unicode(item['name']), item['description'], item['price'], random.randint(10, 100), item['image'], random.randint(0, 5), item['category']
        ) + "\n")
