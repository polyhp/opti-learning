import re

with open("resources/views/components/search-bar.blade.php", "r") as f:
    code = f.read()

# 1. Container
code = re.sub(
    r'class="(w-full.*?) bg-navy-900 lg:bg-white rounded-2xl lg:rounded-full shadow-lg border border-navy-700/50 lg:border-gray-100 ring-1 ring-orange-500/20 lg:ring-0(.*?)"',
    r'class="\1 bg-[#0B1A3E] rounded-full shadow-md border border-[#F97316]/40 ring-1 ring-[#F97316]/30\2"',
    code
)

# 2. Field containers
code = re.sub(
    r'px-4 lg:px-5 py-2 lg:py-3 hover:bg-navy-800 lg:hover:bg-gray-50 transition( rounded-l-2xl lg:rounded-l-full)?',
    r'px-3 lg:px-4 py-1.5 hover:bg-[#122255] transition\1',
    code
)
code = re.sub(r'rounded-l-2xl lg:rounded-l-full', r'rounded-l-full', code)

# 3. Borders
code = re.sub(r'border-navy-700/50 lg:border-gray-200', r'border-[#F97316]/20', code)
code = re.sub(r'border-navy-700/50 lg:border-transparent', r'border-transparent', code)

# 4. Text classes for selections
code = re.sub(r'lg:text-gray-700', r'', code)
code = re.sub(r'lg:text-navy-900', r'', code)
code = re.sub(r'lg:text-gray-400', r'', code)
code = re.sub(r'text-white lg:text-gray-700', r'text-white', code)
code = re.sub(r'text-orange-400 lg:text-gray-400', r'text-[#F97316]', code)
code = re.sub(r'text-orange-500 lg:text-gray-400', r'text-[#F97316]', code)
code = re.sub(r'bg-[#0B1A3E] lg:bg-white', r'bg-[#0B1A3E]', code)
code = re.sub(r'bg-navy-900 lg:bg-white', r'bg-[#0B1A3E]', code)
code = re.sub(r'border-navy-700 lg:border-gray-100', r'border-[#F97316]/30', code)
code = re.sub(r'border-navy-800 lg:border-gray-100', r'border-[#F97316]/20', code)
code = re.sub(r'bg-navy-900/50 lg:bg-transparent', r'bg-[#0B1A3E]/90', code)
code = re.sub(r'bg-navy-800 lg:bg-gray-50', r'bg-[#122255]', code)
code = re.sub(r'focus:ring-orange-500 lg:focus:ring-0', r'focus:ring-[#F97316]', code)
code = re.sub(r'hover:bg-orange-500/10 lg:hover:bg-orange-50', r'hover:bg-[#F97316]/10', code)
code = re.sub(r'bg-orange-500/20 lg:bg-orange-50', r'bg-[#F97316]/20', code)
code = re.sub(r'text-orange-400 lg:text-orange-500', r'text-[#F97316]', code)
code = re.sub(r'text-gray-200 lg:text-gray-700', r'text-gray-300', code)
code = re.sub(r'hover:bg-orange-500 lg:hover:bg-orange-50', r'hover:bg-[#F97316]', code)
code = re.sub(r'hover:text-white lg:hover:text-gray-900', r'hover:text-white', code)
code = re.sub(r'bg-orange-500 lg:bg-orange-50', r'bg-[#F97316]', code)
code = re.sub(r'text-white lg:text-orange-500', r'text-white', code)

# Sizes
code = re.sub(r'text-xs lg:text-sm', r'text-[10px] lg:text-xs', code)
code = re.sub(r'w-\[130px\]', r'w-[110px]', code)
code = re.sub(r'py-1\.5 lg:py-2', r'py-1', code)

# Submit button area
code = re.sub(r'p-1\.5 lg:p-2 lg:pr-2 bg-transparent lg:bg-white rounded-r-2xl lg:rounded-r-full', r'p-1 lg:p-1.5 lg:pr-1.5 bg-transparent rounded-r-full', code)
code = re.sub(r'border-navy-700/50 lg:border-0', r'border-[#F97316]/20 border-l', code)
code = re.sub(r'p-2\.5 lg:p-4 rounded-xl lg:rounded-full', r'p-1.5 lg:p-2.5 rounded-full', code)

with open("resources/views/components/search-bar.blade.php", "w") as f:
    f.write(code)

