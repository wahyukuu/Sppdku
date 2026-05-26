import os, re

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Dictionary mapping FA icons to Lucide icons
    icon_map = {
        'fa-user-plus': 'user-plus',
        'fa-user-shield': 'shield',
        'fa-user-tie': 'briefcase',
        'fa-user': 'user',
        'fa-users': 'users',
        'fa-pen-to-square': 'edit',
        'fa-trash-can': 'trash-2',
        'fa-trash': 'trash-2',
        'fa-arrow-left': 'arrow-left',
        'fa-save': 'save',
        'fa-plus-circle': 'plus-circle',
        'fa-plus': 'plus',
        'fa-calendar-check': 'calendar-check',
        'fa-print': 'printer',
        'fa-plane-departure': 'plane-takeoff',
        'fa-chart-pie': 'pie-chart',
        'fa-wallet': 'wallet',
        'fa-receipt': 'receipt',
        'fa-file-lines': 'file-text',
        'fa-file-invoice': 'file-spreadsheet',
        'fa-right-from-bracket': 'log-out',
        'fa-bars': 'menu',
        'fa-bell': 'bell',
        'fa-gear': 'settings',
        'fa-magnifying-glass': 'search',
        'fa-eye-slash': 'eye-off',
        'fa-eye': 'eye',
        'fa-check': 'check',
        'fa-xmark': 'x',
        'fa-envelope': 'mail',
        'fa-lock': 'lock',
        'fa-file-pdf': 'file-text'
    }

    # regex to find <i class="..."></i> where class contains fa-
    def replacer(match):
        class_str = match.group(1)
        
        # Determine lucide icon name
        lucide_icon = 'circle' # default
        for fa, lu in icon_map.items():
            if fa in class_str:
                lucide_icon = lu
                break
        
        # Keep non-fa classes (like text-slate-500, me-2, etc.)
        other_classes = []
        for cls in class_str.split():
            if not cls.startswith('fa-') and cls not in ['fa', 'fas', 'far', 'fab', 'fa-solid', 'fa-regular']:
                other_classes.append(cls)
        
        classes = ' '.join(other_classes)
        if classes:
            return f'<i data-lucide="{lucide_icon}" class="{classes}"></i>'
        else:
            return f'<i data-lucide="{lucide_icon}"></i>'

    new_content = re.sub(r'<i\s+class=\"([^\"]*?fa-[^\"]*?)\"\s*>\s*</i>', replacer, content)
    
    if new_content != content:
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f'Updated {filepath}')

for root, dirs, files in os.walk('d:/Xampp1/htdocs/sppdku/app/Views'):
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))
print('Done')
