#!/bin/env python3
# A John Shots can be found there ==> https://github.com/funilrys/A-John-Shots
from os import chdir, getcwd, path

import a_john_shots
from termcolor import colored

"""The following search every files which match regex, print the result on screen and save the results under hashes.json."""
regex = r'.*'

if getcwd().endswith('bin'):
    chdir('..')

if path.isdir('./public/vendor'):
    a_john_shots.get('./',search=regex,algorithm='all',exclude=['public\/vendor'],output=True,output_destination='./hashes.json')
else:
    a_john_shots.get('./',search=regex,algorithm='all',output=True,output_destination='./hashes.json')
