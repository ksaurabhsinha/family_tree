define message
	@echo "${LIGHT_GREEN} --------------------------------------------------------${NC}"
	@echo "${LIGHT_GREEN}  $(1)"
	@echo "${LIGHT_GREEN} --------------------------------------------------------${NC}"
endef

intro_text:
	clear
	@echo "${LIGHT_GREEN}"
	@echo "Welcome, I am setting it up for you.."
	@echo "${RED}"
	@echo "==================================================="
	@echo "${NC}"