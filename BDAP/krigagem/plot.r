library(ggplot2)
library(stringr)
library(pals)


args <- commandArgs(TRUE)     
tx <- args[1]    
ty <- args[2]
tv <- args[3]


x<-str_split(tx,',')
y<-str_split(ty,',')
v<-str_split(tv,',')


for (i in 1:length(x)){
  x[[i]]<-as.double(x[[i]])
}

for (i in 1:length(y)){
  y[[i]]<-as.double(y[[i]])
}

for (i in 1:length(v)){
  v[[i]]<-as.double(v[[i]])
}

dados<-data.frame(lat=y, long=x, val=v)
names(dados)[1:3] <- c('latitude', 'longitude', 'valor')

png(filename="valores_observados.png", width=600, height=400)

ggplot(dados, aes(y = latitude, x = longitude, color = valor)) +
  labs(x='', y='', title = '')+
  theme_test()+
  geom_point(shape = 15, size = 7)


dev.off()

