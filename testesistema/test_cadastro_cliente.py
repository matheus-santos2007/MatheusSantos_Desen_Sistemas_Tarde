from selenium import webdriver
from selenium.webdriver.common.by import By
import time

#COnfiguração do webdriver(nesse exemplo.estamos usando o Chrome)
driver = webdriver.Chrome()

#Acessa a página de cadastro usando o caminho absoluto com o protocolo file://
#Certifique-se de que o caminho está apontado para o arquivo HTML específico
driver.get("file:///C:/Users/matheus_santos72/Downloads/testesistema/index.html")

#Preenche o campo Nome
nome_input = driver.find_element(By.ID, "name")
nome_input.send_keys("João da Silva")

#Preenche o campo CPF
cpf_input = driver.find_element(By.ID, "cpf")
cpf_input.send_keys("12345678901")

#Preenche o campo endereço
endereco_input = driver.find_element(By.ID, "address")
endereco_input.send_keys("Rua das Flores, 123")

#Pereenche o campo telefone

telefone_input = driver.find_element(By.ID, "phone")
telefone_input.send_keys("11987654321")

#CLica eno botão de Cadastro 
submit_button = driver.find_element(By.CSS_SELECTOR, "button[type='submit']")
submit_button.click()

#Aguarda um momento para vizualazar o resultado (em um aplicação real,você verificaria a resposta)
time.sleep(600)

#Fecha o navegador
driver.quit()