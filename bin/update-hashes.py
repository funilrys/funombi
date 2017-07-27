#!/bin/env python
# A John Shots can be found there ==> https://github.com/funilrys/A-John-Shots
import a_john_shots 

"""The following search every files which match regex, print the result on screen and save the results under hashes.json.""" 
regex = r'.*' 

# This should be the default one
a_john_shots.get('./',search=regex,algorithm='all',output_destination='./hashes.json')

# Uncomment the following if you want to exclude all the public directory
# a_john_shots.get('./',search=regex,algorithm='all',exclude=['public'],output_destination='./hashes.json')

# Uncomment the following if you want to exclude all the vendor directory
# a_john_shots.get('./',search=regex,algorithm='all',exclude=['public\/vendor'],output=True,output_destination='./hashes.json')

# Uncomment the following if you want to exclude the images, js, styles and vendor directories
# a_john_shots.get('./',search=regex,algorithm='all',exclude=['public\/vendor','public\/images','public\/js','public\/styles'],output_destination='./hashes.json')