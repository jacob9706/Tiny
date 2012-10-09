import sys, os, shutil, errno

arguments = [
	"--help",
	"new-project <projectName>"
]

length = len(sys.argv)
if length < 2:
	print 'You must supply an argument. For help use --help'
	sys.exit()

elif sys.argv[1] == "--help":
	for i in arguments:
		print i

elif length > 2:
	if sys.argv[1] == "new-project":
		print "Creating new project"
		cplocation = os.getcwd()
		docloc = os.path.dirname(__file__)
		os.system("cp -r " + docloc + "/TinyProjectOutline " + cplocation)
		os.system("mv " + cplocation + "/TinyProjectOutline " + sys.argv[2])